<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'namespace' => 'Tao\Captcha\Controllers',
    'as' => 'tao.captcha.api.'
],  function($router) {
    $router->get(config('captcha.router'), 'CaptchaController@image')->name('image');
    $router->post(config('captcha.router'), 'CaptchaController@validate')->name('image');
});
