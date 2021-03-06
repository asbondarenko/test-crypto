<?php

use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\TrainingCancelRequest;

Route::group([
    'module' => 'Admin',
    'namespace' => 'App\Modules\Admin\Controllers',
    'middleware' => 'web'
], function() {

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get(config('admin.route').'/locale/{locale}', 'AdminController@setLocale')->name('admin.locale');
});

Route::group([
    'module' => 'Admin',
    'namespace' => 'App\Modules\Admin\Controllers',
    'middleware' => ['web', 'auth']
], function() {
    Route::get(config('admin.homeRoute'), config('admin.homeAction','DashboardController@index'));
//    Route::resource('users', 'UserController');
//    Route::resource('roles', 'RoleController');
    Route::get('home', 'DashboardController@index')->name('admin.dashboard');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('dataTables/locale/{locale}', 'AdminController@dataTablesLocale')->name('dataTables.locale');
});

if (Schema::hasTable('menus')) {
    $menus = Menu::with('children')->where('menu_type', '!=', 0)->orderBy('position')->get();
    View::share('menus', $menus);
    if (! empty($menus)) {
        Route::group([
            'module'     => 'Admin',
            'middleware' => ['web', 'auth'],
            'prefix'     => config('admin.route'),
            'as'         => config('admin.route') . '.',
            'namespace'  => 'App\Modules\Admin\Controllers',
        ], function () use ($menus) {
            foreach ($menus as $menu) {
                switch ($menu->menu_type) {
                    case 1:
                        Route::post(strtolower($menu->plural_name) . '/massDelete', [
                            'as'   => strtolower($menu->plural_name) . '.massDelete',
                            'uses' => ucfirst(camel_case($menu->singular_name)) . 'Controller@massDelete'
                        ]);
                        Route::resource(strtolower($menu->plural_name),
                            ucfirst(camel_case($menu->singular_name)) . 'Controller', ['except' => 'show']);
                        break;
                    case 3:
                        Route::get(strtolower($menu->plural_name), [
                            'as'   => strtolower($menu->plural_name) . '.index',
                            'uses' => ucfirst(camel_case($menu->singular_name)) . 'Controller@index',
                        ]);
                        break;
                }
            }
        });
    }
}

Route::group([
    'module'     => 'Admin',
    'middleware' => ['web', 'auth'],
    'prefix'     => config('admin.route'),
    'as'         => config('admin.route') . '.',
    'namespace'  => 'App\Modules\Admin\Controllers',
], function () {
    Route::get('settings/index', 'SettingController@index')->name('settings.index');
    Route::post('settings/index', 'SettingController@indexStore')->name('settings.indexStore');
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/profile', 'UserController@updateProfile')->name('users.updateProfile');
    Route::get('users/{user}/removeAvatar', 'UserController@removeAvatar')->name('users.removeAvatar');
    Route::patch('users/{user}/toggleStatus', 'UserController@toggleStatus')->name('users.toggleStatus');
});

Route::group([
    'module'     => 'Admin',
    'namespace'  => 'App\Modules\Admin\Controllers',
    'middleware' => ['web', 'auth']
], function () {
    // Menu routing
    Route::get(config('admin.route') . '/menu', [
        'as'   => config('admin.route') . '.menu.index',
        'uses' => 'MenuController@index'
    ]);
    Route::post(config('admin.route') . '/menu', [
        'as'   => config('admin.route') . '.menu.store',
        'uses' => 'MenuController@store'
    ]);
    Route::get(config('admin.route') . '/menu/create', [
        'as'   => config('admin.route') . '.menu.create',
        'uses' => 'MenuController@create'
    ]);
    Route::post(config('admin.route') . '/menu/rearrange', [
        'as'   => config('admin.route') . '.menu.rearrange',
        'uses' => 'MenuController@rearrange'
    ]);

    Route::get(config('admin.route') . '/menu/edit/{id}', [
        'as'   => config('admin.route') . '.menu.edit',
        'uses' => 'MenuController@edit'
    ]);
    Route::post(config('admin.route') . '/menu/edit/{id}', [
        'as'   => config('admin.route') . '.menu.edit',
        'uses' => 'MenuController@update'
    ]);

    Route::get(config('admin.route') . '/menu/crud', [
        'as'   => config('admin.route') . '.menu.crud',
        'uses' => 'MenuController@createCrud'
    ]);
    Route::post(config('admin.route') . '/menu/crud', [
        'as'   => config('admin.route') . '.menu.crud.insert',
        'uses' => 'MenuController@insertCrud'
    ]);

    Route::get(config('admin.route') . '/menu/parent', [
        'as'   => config('admin.route') . '.menu.parent',
        'uses' => 'MenuController@createParent'
    ]);
    Route::post(config('admin.route') . '/menu/parent', [
        'as'   => config('admin.route') . '.menu.parent.insert',
        'uses' => 'MenuController@insertParent'
    ]);

    Route::get(config('admin.route') . '/menu/custom', [
        'as'   => config('admin.route') . '.menu.custom',
        'uses' => 'MenuController@createCustom'
    ]);
    Route::post(config('admin.route') . '/menu/custom', [
        'as'   => config('admin.route') . '.menu.custom.insert',
        'uses' => 'MenuController@insertCustom'
    ]);

    Route::get(config('admin.route') . '/actions', [
        'as'   => config('admin.route') . '.actions',
        'uses' => 'UserActionsController@index'
    ]);
    Route::get(config('admin.route') . '/actions/ajax', [
        'as'   => config('admin.route') . '.actions.ajax',
        'uses' => 'UserActionsController@table'
    ]);
});
