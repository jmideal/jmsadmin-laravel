<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\UserRoleModel;

class UserRoleService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new UserRoleModel();
        parent::__construct($validate);
    }

}
