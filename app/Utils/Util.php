<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Util
{
    public static function getDb($connection = null)
    {
        return Db::connection($connection ?: 'mysql');
    }

    public static function getRedis($connection = null)
    {
        return Redis::connection($connection ?: 'default');
    }
}
