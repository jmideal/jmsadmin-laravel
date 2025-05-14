<?php

namespace App\Http\Controllers\System;


use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Http\Validates\System\DictDataValidate;
use App\Services\System\DictDataService;
use App\Utils\ApiResult;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[LogInfo(name: "字典数据管理")]
#[UsePermission("system:dictData:manage")]
class DictDataController extends BasicController
{
    public function __construct()
    {
        $this->validate = new DictDataValidate();
        $this->service = new DictDataService($this->validate);
        parent::__construct();
    }

    #[UsePermission("system:common:query")]
    public function all(Request $request):Response
    {
        $dictType = $request->get('dictType', '');
        $data = [$dictType];
        if (!empty($dictType)) {
            $dictDataService = new DictDataService();
            $data = $dictDataService->selectDictDataListByType($dictType);
        }
        return ApiResult::success($data);
    }
}
