<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Exceptions\ApiException;
use App\Models\System\DictTypeModel;

class DictTypeService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new DictTypeModel();
        parent::__construct($validate);
    }

    public function beforeDelete($id)
    {
        $id = parent::beforeDelete($id);
        $dictDataService = new DictDataService();
        foreach ($id as $val) {
            $info = $this->model->find($val);
            if (!empty($info)) {
                $count = $dictDataService->buildQuery([], ['dict_type', $info->dict_type])->count();
                if ($count > 0) {
                    throw new ApiException($info->dictName . "已分配，不能删除");
                }
            }
        }
        return $id;
    }
}
