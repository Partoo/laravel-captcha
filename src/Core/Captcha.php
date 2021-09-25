<?php

namespace Tao\Captcha\Core;

use Tao\Captcha\Core\Code\AbstractCode;
use Tao\Captcha\Core\Generator\IGenerator;
use Tao\Captcha\Core\Storage\IStorage;

class Captcha
{
    private $code;
    private $storage;
    private $generator;
    private $params;

    public function __construct(AbstractCode $code, IGenerator $generator, IStorage $storage, array $params)
    {
        $this->code = $code;
        $this->storage = $storage;
        $this->generator = $generator;
        $this->params = $params;
        $this->params['background'] = is_array($this->params['background']) ? $this->params['background'] : [$this->params['background']];
        $this->params['colors'] = is_array($this->params['colors']) ? $this->params['colors'] : [$this->params['colors']];

        if (!file_exists($this->params['font'])) {
            $this->params['font'] = __DIR__.'/../resources/fonts/ximai.ttf';
        }
    }

    public function getImage() {
        // Generate captcha code
        $code = $this->code->generate();
        // Generate key for validate
        $cache_key = md5(uniqid(mt_rand(), true));
        // Make generator
        $gen = $this->generator->render($code, $this->params);// Store k-v to storage

        $this->storage->put($cache_key,$code['validationCode']);
        // Frontend need the key
        $gen['validation'] = $cache_key;

        return $gen;
    }

    public function validate($key, $code): bool
    {
        $realCode = $this->storage->get($key);
        if (!empty($realCode)) {
            $this->storage->forget($key);
            return mb_strtolower($realCode) === mb_strtolower($code);
        }
        return false;
    }
}
