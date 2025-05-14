<?php

namespace App\Services\System;


use App\Basic\BasicService;
use App\Models\System\NoticeModel;

class NoticeService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new NoticeModel();
        parent::__construct($validate);
    }

}
