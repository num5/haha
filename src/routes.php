<?php

Route::group([
    'middleware' => ['web', 'admin'],
    'prefix' => config("admin.route.prefix"),
    'namespace' => config("admin.route.namespace"),
], function() {

    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::post('change_mod', 'HomeController@changMod')->name('admin.mod.change');

    // 验证
    Route::group(['prefix' => 'auth'], function (){
        Route::get('login', 'Admin\\AuthController@getlogin')->name('admin.login');
        Route::post('login', 'Admin\\AuthController@postlogin');
        Route::post('logout', 'Admin\\AuthController@postlogout')->name('admin.logout');
    });

    Route::group(['prefix' => 'my'], function (){
        // 账号管理
        Route::get('profile','Admin\\AdminController@profile')->name('my.profile');
        Route::put('profile','Admin\\AdminController@profileUpdate')->name('my.profile');
        Route::get('reset','Admin\\AdminController@resetPassword')->name('my.reset');
        Route::put('reset','Admin\\AdminController@resetUpdate')->name('my.reset');
        // 通知
        Route::get('notification/{notification}', 'Admin\\NotificationController@show')->name('notification.show');
    });

    Route::group(['prefix' => 'system'], function (){
        Route::resource('admin','Admin\\AdminController');

        // 权限
        Route::get('permission/child/{permission}','Admin\\PermissionController@childIndex')->name('permission.child');
        Route::resource('permission','Admin\\PermissionController');

        // 角色
        Route::resource('role','Admin\\RoleController');
    });

});