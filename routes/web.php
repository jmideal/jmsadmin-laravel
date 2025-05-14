<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\AuthController::class)->middleware(['auth'])->group(function () {
    Route::get('auth/captchaImage', 'captchaImage');
    Route::post('auth/login', 'login');
    Route::post('auth/logout', 'logout');
    Route::get('auth/getInfo', 'getInfo');
    Route::get('auth/getRouters', 'getRouters');
});

Route::prefix('system/user/')->controller(\App\Http\Controllers\System\UserController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::post('pwdEdit', 'pwdEdit');
    Route::get('deptTreeList', 'deptTreeList');
});


Route::prefix('system/role/')->controller(\App\Http\Controllers\System\RoleController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::post('dataScopeEdit', 'dataScopeEdit');
    Route::get('deptTreeList', 'deptTreeList');
});

Route::prefix('system/profile/')->controller(\App\Http\Controllers\System\ProfileController::class)->middleware(['auth'])->group(function () {
    Route::get('info', 'info');
    Route::post('edit', 'edit');
    Route::post('avatarEdit', 'avatarEdit');
    Route::post('pwdEdit', 'pwdEdit');
});

Route::prefix('system/post/')->controller(\App\Http\Controllers\System\PostController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
});

Route::prefix('system/notice/')->controller(\App\Http\Controllers\System\NoticeController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
});

Route::prefix('system/menu/')->controller(\App\Http\Controllers\System\MenuController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::get('treeList', 'treeList');
    Route::get('roleMenuTreeList', 'roleMenuTreeList');
});

Route::prefix('system/dictType/')->controller(\App\Http\Controllers\System\DictTypeController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::get('optionSelectList', 'optionSelectList');
});

Route::prefix('system/dictData/')->controller(\App\Http\Controllers\System\DictDataController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::get('all', 'all');
});

Route::prefix('system/dept/')->controller(\App\Http\Controllers\System\DeptController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::get('excludeList', 'excludeList');
});

Route::prefix('system/config/')->controller(\App\Http\Controllers\System\ConfigController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::post('add', 'add');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::get('keyInfo', 'keyInfo');
});

Route::prefix('system/common/')->controller(\App\Http\Controllers\System\CommonController::class)->middleware(['auth'])->group(function () {
    Route::post('upload', 'upload');
});

Route::prefix('monitor/operlog/')->controller(\App\Http\Controllers\Monitor\OperLogController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::post('remove', 'remove');
    Route::post('allRemove', 'allRemove');
});

Route::prefix('monitor/online/')->controller(\App\Http\Controllers\Monitor\OnlineController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::post('remove', 'remove');
    Route::post('loginStatusRemove', 'loginStatusRemove');
});

Route::prefix('monitor/logininfor/')->controller(\App\Http\Controllers\Monitor\LogininforController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::post('remove', 'remove');
    Route::post('allRemove', 'allRemove');
    Route::post('lockRemove', 'lockRemove');
});

Route::prefix('monitor/cache/')->controller(\App\Http\Controllers\Monitor\CacheController::class)->middleware(['auth'])->group(function () {
    Route::get('nameList', 'nameList');
    Route::get('keyList', 'keyList');
    Route::get('cacheInfo', 'cacheInfo');
    Route::post('cacheNameRemove', 'cacheNameRemove');
    Route::post('cacheKeyRemove', 'cacheKeyRemove');
    Route::post('cacheAllRemove', 'cacheAllRemove');
});

Route::prefix('tool/gen/')->controller(\App\Http\Controllers\Tool\GenController::class)->middleware(['auth'])->group(function () {
    Route::get('list', 'list');
    Route::get('info', 'info');
    Route::get('sableTableList', 'sableTableList');
    Route::get('preview', 'preview');
    Route::post('tableImport', 'tableImport');
    Route::post('edit', 'edit');
    Route::post('remove', 'remove');
    Route::post('zipCodeGenerate', 'zipCodeGenerate');
});
