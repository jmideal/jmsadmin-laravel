<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\DictTypeValidate;
use App\Services\System\DictTypeService;
use App\Utils\ApiResult;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[LogInfo(name: "字典管理")]
class DictTypeController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DictTypeValidate();
        $this->service = new DictTypeService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function optionSelectList(Request $request):Response
    {
        $ret = $this->service->getListWithoutPage([]);
        return ApiResult::success($ret);
    }

}
