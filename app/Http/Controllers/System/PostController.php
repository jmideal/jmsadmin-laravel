<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\PostValidate;
use App\Services\System\PostService;
use App\Utils\ApiResult;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[LogInfo(name: "岗位管理")]
class PostController extends BasicController
{
    public function __construct()
    {
        $this->validate = new PostValidate();
        $this->service = new PostService($this->validate);
        parent::__construct();
    }

}
