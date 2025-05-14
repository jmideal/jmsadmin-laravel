<?php

namespace App\Http\Controllers\Monitor;


use App\Annotation\LogInfo;
use App\Basic\BasicController;
use App\Constant\Constants;
use App\Utils\ApiResult;
use App\Utils\Token;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[LogInfo(name: "在线用户管理")]
class OnlineController extends BasicController
{
    public function list(Request $request): Response
    {
        $ipaddr = $request->get("ipaddr");
        $userName = $request->get("userName");
        $keys = Util::getRedis()->keys(Constants::LOGIN_TOKEN_KEY . "*");
        $list = [];
        foreach ($keys as $key) {
            $value = Util::getRedis()->get($key);
            if (empty($value)) {
                continue;
            }
            $user = unserialize($value);
            if (empty($user)) {
                continue;
            }
            $user['token_id'] = $user['uuid'];
            unset($user['uuid']);
            if (!empty($ipaddr) && !empty($userName)) {
                if ($user['login_ip'] == $ipaddr && $user['user_name'] == $userName) {
                    $list[] = $user;
                }
            } elseif (!empty($ipaddr)) {
                if ($user['login_ip'] == $ipaddr) {
                    $list[] = $user;
                }
            } elseif (!empty($userName)) {
                if ($user['user_name'] == $userName) {
                    $list[] = $user;
                }
            } else {
                $list[] = $user;
            }
        }
        array_multisort(array_column($list,'login_date'),SORT_DESC,$list);
        return ApiResult::success(['total' => count($list), 'rows' => $list]);
    }

    public function loginStatusRemove(Request $request):Response
    {
        $uuid = $request->post("tokenId");
        if (empty($uuid)) {
            return ApiResult::error("参数有误");
        }
        $tokenUtils = new Token();
        Util::getRedis()->del($tokenUtils->getTokenKey($uuid));
        return ApiResult::success();
    }
}
