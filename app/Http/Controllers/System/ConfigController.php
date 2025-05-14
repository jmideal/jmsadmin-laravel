<?php

namespace App\Http\Controllers\System;


use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\ConfigValidate;
use App\Services\System\ConfigService;
use App\Utils\ApiResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[LogInfo(name: "参数管理")]
class ConfigController extends BasicController
{
    public function __construct()
    {
        $this->validate = new ConfigValidate();
        $this->service = new ConfigService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function keyInfo(Request $request): Response
    {
        $configKey = $request->get('configKey', '');
        $ret = $this->service->getKeyInfo($configKey);
        return ApiResult::success($ret);
    }
}
