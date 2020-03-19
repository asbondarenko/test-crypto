<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(array('module' => 'Api', 'namespace' => 'Api\Controllers'), function () {
    Route::group(['middleware' => 'auth:api'], function () {

        // Users
        Route::group(['prefix' => '/users'], function () {
            Route::get('/', 'UserController@authenticated');
            Route::put('/', 'UserController@update');
        });

        // Recommendations
        Route::group(['prefix' => '/recommendations'], function () {
            Route::get('/', 'RecommendationController@index');
            Route::post('/', 'RecommendationController@store');
            Route::post('/{recommendation}/like', 'RecommendationController@like');
            Route::post('/{recommendation}/dislike', 'RecommendationController@dislike');
            Route::post('/{recommendation}/removeAssessment', 'RecommendationController@removeAssessment');
        });

        // Cryptocurrencies
        Route::group(['prefix' => '/cryptocurrencies'], function () {
            Route::get('/', 'CryptocurrencyController@index');
            Route::get('/{cryptocurrency}', 'CryptocurrencyController@show');
        });

        // Dashboards
        Route::group(['prefix' => '/dashboards'], function () {
            Route::get('/', 'DashboardController@index');
            Route::post('/', 'DashboardController@store');
            Route::put('/{dashboard}', 'DashboardController@update');
            Route::delete('/{dashboard}', 'DashboardController@destroy');
        });

        // Assets
        Route::group(['prefix' => '/assets'], function () {
            Route::get('/', 'AssetController@index');
        });

        // Settings
        Route::group(['prefix' => '/settings'], function () {
            Route::get('/termsAndConditions', 'SettingController@termsAndConditions');
        });
    });
});

Route::group(array('module' => 'Api', 'namespace' => 'Api\Controllers'), function () {
    Route::group(['middleware' => 'api'], function () {
        Route::post('register', 'Auth\RegisterController@register');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('login/refreshToken', 'Auth\LoginController@refreshToken');
        Route::post('login/social', 'Auth\LoginController@social');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });
});
