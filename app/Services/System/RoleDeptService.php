<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\RoleDeptModel;

class RoleDeptService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new RoleDeptModel();
        parent::__construct($validate);
    }
    public function batchInsertRoleDept($batchData)
    {
        return $this->model::insert($batchData);
    }
    public function deleteRoleDeptByRoleIds($roleIds)
    {
        $roleIds = parent::beforeDelete($roleIds);
        return $this->model->whereIn('role_id', $roleIds)->delete();
    }

}
