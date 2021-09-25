<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'namespace' => 'Tao\Captcha\Controllers',
    'as' => 'tao.captcha.api.'
],  function($router) {
    $router->get(config('tao.captcha.router'), 'CaptchaController@image')->name('image');
    $router->post(config('tao.captcha.router'), 'CaptchaController@validate')->name('image');
});
