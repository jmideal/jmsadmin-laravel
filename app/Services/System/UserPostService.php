<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\UserPostModel;

class UserPostService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new UserPostModel();
        parent::__construct($validate);
    }

}
