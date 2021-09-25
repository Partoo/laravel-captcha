<?php

namespace Tao\Captcha;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Tao\Captcha\Core\Captcha;

class CaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'tao.captcha');
        $this->mergeConfigFrom(__DIR__ . '/../config/captcha.php', 'tao.captcha');
        $this->publishes([
            __DIR__ . '/../config/captcha.php' => config_path('captcha.php'),
            __DIR__ . '/resources/lang' => resource_path('lang'),
        ],'captcha');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    public function register()
    {
        $this->app->singleton(Captcha::class, static function (Application $application) {
            $config = $application['config']['tao']['captcha'];
            $storage = $application->make($config['storage']);
            $generator = $application->make($config['generator']);
            $code = $application->make($config['code']);

            return new Captcha($code, $generator, $storage, $config);
        });
    }
}
