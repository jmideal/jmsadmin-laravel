<?php

namespace App\Http\Controllers\System;

use App\Annotation\LogInfo;
use App\Annotation\UsePermission;
use App\Basic\BasicController;
use App\Utils\ApiResult;
use App\Utils\Random;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[LogInfo(name: "公共权限")]
class CommonController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function upload(Request $request): Response
    {
        $file = $request->file('file');
        if ($file && $file->isValid()) {
            if (!in_array(strtolower($file->extension()), ['jpg', 'jpeg', 'png'])) {
                return ApiResult::error("只支持'jpg', 'jpeg', 'png'类型文件");
            }
            $uploadPath = config('app.upload_path');
            $dir = '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $fileName = Random::uuid() . '.' . $file->extension();
            $adminInfo = adminInfo();
            //
            $fileData = [
                'extension'     => $file->extension(),
                'mime_type'     => $file->getMimeType(),
                'file_name'     => $file->getClientOriginalName(),
                'size'          => $file->getSize(),
                'path'          => $dir . $fileName,
                'create_by'     => $adminInfo['user_id']
            ];
            //print_r($fileData);
            //
            if (!file_exists($uploadPath . $dir)) {
                mkdir($uploadPath . $dir, 0755, true);
            }
            move_uploaded_file($file->getRealPath(), $uploadPath . $dir . $fileName);

            return ApiResult::success(['fileName' => $fileName, 'filePath' => $dir . $fileName, 'ext' => $file->extension()]);
        }
        return ApiResult::error("上传出现错误");
    }
}
