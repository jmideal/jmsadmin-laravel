<?php

namespace App\Providers;

use Closure;
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
