<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\DeptValidate;
use App\Services\System\DeptService;
use App\Utils\ApiResult;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[LogInfo(name: "部门管理")]
class DeptController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DeptValidate();
        $this->service = new DeptService($this->validate);
        parent::__construct();
    }

    public function list(Request $request):Response
    {
        $params = $this->validate->run('search', $request->query());
        $ret = $this->service->getListWithoutPage($params, []);
        return ApiResult::success($ret);
    }

    #[UsePermission("system:common:query")]
    public function excludeList(Request $request):Response
    {
        $deptId = $request->get('deptId');
        $ret = $this->service->getListWithoutPage([], []);
        $list = $ret;
        if (!empty($deptId)) {
            $items = [];
            foreach ($ret as $v) {
                if ($v['dept_id'] == $deptId || in_array($deptId, explode(',', $v['ancestors']))) {
                    continue;
                }
                $items[] = $v;
            }
            $list = $items;
        }
        return ApiResult::success($list);
    }
}
