<?php

namespace App\Http\Middleware;

use App\Services\Monitor\OperLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class OperationLog
{
    public function handle(Request $request, Closure $next)
    {
        $request->__startTime = microtime(true);
        $response = $next($request); // 继续向洋葱芯穿越，直至执行控制器得到响应
        $content = '';
        $operLogService = new OperLogService();
        if ($response instanceof StreamedResponse) {
            $code = $response->getStatusCode();
            $message = '';
        } else {
            $content = $response->getContent();
            $object = @json_decode($content, true);
            $code = $object['code'] ?? 500 ;
            $message = $object['msg'] ?? '';
        }
        if ($response->getStatusCode() == 200) {
            if ($code == 200) {
                $operLogService->logInsert(1, $message, $content);
            } else {
                $operLogService->logInsert(0, $message, $content);
            }
        } else {
            $operLogService->logInsert(0, $message, $content);
        }
        return $response;
    }
}
