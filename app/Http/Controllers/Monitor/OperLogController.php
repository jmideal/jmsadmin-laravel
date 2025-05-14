<?php

namespace App\Http\Controllers\Monitor;


use App\Annotation\LogInfo;
use App\Basic\BasicController;
use App\Http\Validates\Monitor\OperLogValidate;
use App\Services\Monitor\OperLogService;
use App\Utils\ApiResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[LogInfo(name: "操作日志管理")]
class OperLogController extends BasicController
{
    public function __construct()
    {
        $this->validate = new OperLogValidate();
        $this->service = new OperLogService($this->validate);
        parent::__construct();
    }

    public function allRemove(Request $request):Response
    {
        return $this->service->allRemove() ? ApiResult::success() : ApiResult::error();
    }
}
