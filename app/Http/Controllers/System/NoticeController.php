<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\NoticeValidate;
use App\Services\System\NoticeService;
use App\Utils\ApiResult;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[LogInfo(name: "通知公告管理")]
class NoticeController extends BasicController
{
    public function __construct()
    {
        $this->validate = new NoticeValidate();
        $this->service = new NoticeService($this->validate);
        parent::__construct();
    }
}
