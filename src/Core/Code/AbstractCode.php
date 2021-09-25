<?php

namespace Tao\Captcha\Core\Code;

/**
 * Abstract Code Generate Class
 */
abstract class AbstractCode
{
    protected $num_config;

    public function __construct()
    {
        $this->num_config = config('tao.captcha.codeType');
    }

    public function generate(): array
    {
        if ($this->num_config['isAscii']) {
            return [
                'code' => $this->asciiCode(),
                'validationCode' => $this->validationCode()
            ];
        }
        return [
            'code' => $this->nonAsciiCode(),
            'validationCode' => $this->validationCode()
        ];
    }

    // Every child class need write these functions to adapt different scene.
    abstract protected function asciiCode();
    abstract protected function nonAsciiCode();
    abstract protected function validationCode();
}
