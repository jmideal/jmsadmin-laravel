<?php

namespace App\Utils;

use Illuminate\Http\Response;

class ApiResult
{
    static function success($data = [], $msg = '操作成功'): Response
    {
        $data = Convert::toLowerCamelCaseArray($data);
        $msg = empty($msg) ? '操作成功' : $msg;
        $ret = ["code" => 200, "msg" => $msg, "data" => $data];
        return new Response(json_encode($ret, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
    }

    static function error($msg = '操作失败', $code = 500, $data = null): Response
    {
        $msg = empty($msg) ? '操作失败' : $msg;
        $ret = ["code" => $code, "msg" => $msg];
        if (!empty($data)) {
            if (is_object($data)) {
                $data = (array)$data;
            }
            $data = Convert::toLowerCamelCaseArray($data);
            $ret['data'] = $data;
        }
        return new Response(json_encode($ret, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
    }
}
