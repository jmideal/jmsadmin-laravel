<?php

namespace App\Providers;

use App\Exceptions\ApiException;
use App\Utils\ApiResult;
use Closure;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        RateLimiter::for('login', function (Request $request) {
            $adminInfo = adminInfo();
            return Limit::perMinute(20)->by($adminInfo['user_id'] ?? $request->ip())->response(function (Request $request, array $headers) {
                throw new ApiException('请求频率超限，请休息一会');
            });
        });
        //mobile
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^1[3-9]\d{9}$/', $value) === 1;
        });
        Validator::replacer('mobile', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });
        //date_between
        Validator::extend('date_between', function ($attribute, $value, $parameters, $validator) {
            if (!is_array($value) || count($value) != 2 || !strtotime($value[0]) || !strtotime($value[1]) || strtotime($value[0]) > strtotime($value[1])) {
                return false;
            }
            return true;
        });
        Validator::replacer('date_between', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });
    }
}
