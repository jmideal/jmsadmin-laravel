<?php

namespace App\Services\System;

use App\Basic\BasicService;
use App\Constant\Constants;
use App\Models\System\ConfigModel;
use App\Utils\Util;

class ConfigService extends BasicService
{
    public function __construct($validate = null)
    {
        $this->model = new ConfigModel();
        parent::__construct($validate);
    }

    public function getKeyInfo($configKey)
    {
        $cacheKey = Constants::CONFIG_KEY . $configKey;
        $value = Util::getRedis()->get($cacheKey);
        if (is_null($value)) {
            $ret = $this->model->where('config_key', $configKey)->first();
            $value = $ret ? $ret->config_value : '' ;
            if ($value !== '') {
                $dataCacheExpire = config('app.data_cache_expire');
                Util::getRedis()->setex($cacheKey, $dataCacheExpire, $value);
            }
        }
        return $value;
    }

}
