<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\PostModel;

class PostService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new PostModel();
        parent::__construct($validate);
    }

}
