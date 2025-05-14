<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\RoleMenuModel;

class RoleMenuService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new RoleMenuModel();
        parent::__construct($validate);
    }
    public function batchInsertRoleMenu($batchData)
    {
        return $this->model::insert($batchData);
    }

    public function deleteRoleMenuByRoleIds($roleIds)
    {
        $roleIds = parent::beforeDelete($roleIds);
        return $this->model->whereIn('role_id', $roleIds)->delete();
    }
}
