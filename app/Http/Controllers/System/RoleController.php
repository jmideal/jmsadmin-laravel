<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Utils\ApiResult;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\System\DeptService;
use App\Http\Validates\System\RoleValidate;
use App\Services\System\RoleService;


#[LogInfo(name: "角色管理")]
class RoleController extends BasicController
{
    public function __construct()
    {
        $this->validate = new RoleValidate();
        $this->service = new RoleService($this->validate);
        parent::__construct();
    }

    public function info(Request $request): Response
    {
        $roleId = $request->get('roleId', '0');
        if (empty($roleId)) {
            return ApiResult::error("参数有误");
        }
        $isSuperScope = adminIsSuperScope();
        if (!$isSuperScope) {
            return ApiResult::error("无权执行该操作");
        }
        $ret = $this->service->getInfo($roleId);
        $ret['menu_check_strictly'] = (boolean)$ret['menu_check_strictly'];
        $ret['dept_check_strictly'] = (boolean)$ret['dept_check_strictly'];
        $dataScopeList = $this->service->getDataScopeList(0);
        $ret['data_scope_list'] = $dataScopeList;
        return ApiResult::success($ret);
    }

    #[UsePermission("system:common:query")]
    public function deptTreeList(Request $request):Response
    {
        $roleId = $request->get('roleId', '0');
        if (empty($roleId)) {
            return ApiResult::error("参数有误");
        }
        $deptService = new DeptService();
        $ret['checkedKeys'] = $deptService->selectDeptListByRoleId($roleId);
        $ret['depts'] = $deptService->selectDeptTreeList();
        return ApiResult::success($ret);
    }

    public function dataScopeEdit(Request $request):Response
    {
        $params = $this->validate->run('dataScopeEdit', $request->post());
        $roleService = new RoleService();
        $params = $roleService->preDataScopeUpdate($params);
        $ret = $roleService->dataScopeUpdate($params);
        return ApiResult::success($ret);
    }
}
