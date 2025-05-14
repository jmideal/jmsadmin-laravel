<?php

namespace App\Http\Controllers\Monitor;


use App\Annotation\LogInfo;
use App\Basic\BasicController;
use App\Http\Validates\Monitor\LogininforValidate;
use App\Services\Monitor\LogininforService;
use App\Utils\ApiResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[LogInfo(name: "登录日志管理")]
class LogininforController extends BasicController
{
    public function __construct()
    {
        $this->validate = new LogininforValidate();
        $this->service = new LogininforService($this->validate);
        parent::__construct();
    }
    public function allRemove(Request $request):Response
    {
        return $this->service->allRemove() ? ApiResult::success() : ApiResult::error();
    }

    public function lockRemove(Request $request):Response
    {
        $userName = $request->post('userName');
        if (!empty($userName)) {
            $this->service->unLockUserCache($userName);
        }
        return ApiResult::success();
    }
}
