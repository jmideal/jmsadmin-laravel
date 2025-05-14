<?php

namespace App\Http\Middleware;


use App\Services\AuthService;
use App\Utils\ApiResult;
use App\Utils\Random;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

class LoginControl
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->__requestId = Random::uuid();
        $authService = new AuthService();
        $user = $authService->getLoginUser();
        if (!empty($user['uuid']) && !empty($user['user_id']) && !empty($user['expire_time'])) {
            //判断是否需要刷新token
            $tokenRefresh = config('app.token.jwt.token_refresh');
            if (strtotime($user['expire_time']) - time() < $tokenRefresh) {
                $authService->refreshLoginUser($user);
            }
            //将用户登录信息寄存在Request对象上
            $request->adminInfo = $user;
            // 已经登录，请求继续向洋葱芯穿越
            return $next($request);
        }
        // 通过反射获取控制器哪些方法不需要登录
        $controller = new ReflectionClass($request->route()->getController());
        $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];

        // 访问的方法需要登录
        if (!in_array('*', $noNeedLogin) && !in_array($request->route()->getActionMethod(), $noNeedLogin)) {
            // 拦截请求，返回一个JSON响应，请求停止向洋葱芯穿越
            return ApiResult::error("未登录或登录已过期，请重新登录", 401);
        }

        // 不需要登录，请求继续向洋葱芯穿越
        return $next($request);
    }
}
