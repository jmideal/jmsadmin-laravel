<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $debug = config('app.debug', true);
        if ($e instanceof ApiException) {
            //接口异常
            $code = $e->getCode();
            $httpCode = 200;
            $message = $e->getMessage();
        } elseif ($e instanceof ValidateException) {
            //验证器异常
            $code = 500;
            $httpCode = 200;
            $message = $e->getMessage();
        } elseif ($e instanceof NotFoundHttpException) {
            $code = 404;
            $httpCode = 200;
            $message = $e->getMessage();
        } elseif ($e instanceof ModelNotFoundException) {
            $code = 500;
            $httpCode = 200;
            $message = '未找到有效数据';
        } else {
            //系统异常
            $code = 500;
            $httpCode = 500;
            $exceptionMessage = $e->getMessage();
            $message = "系统出现异常，请联系管理员";
        }
        $data = [
            'code' => $code,
            'msg' => $message,
        ];
        if ($debug) {
            $data['request_url'] = $request->method() . ' ' . $request->uri();
            $data['timestamp'] = date('Y-m-d H:i:s');
            $data['client_ip'] = $request->getClientIp();
            $data['request_param'] = $request->all();
            $data['exception_handle'] = get_class($e);
            $data['exception_info'] = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => explode("\n", $e->getTraceAsString())
            ];
        }
        return new Response(json_encode($data, JSON_UNESCAPED_UNICODE), $httpCode, ['Content-Type' => 'application/json;charset=utf-8'], $code, !empty($exceptionMessage)?$exceptionMessage:$message);
    }
}
