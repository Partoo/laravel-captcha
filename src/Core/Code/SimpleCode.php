<?php

namespace Tao\Captcha\Core\Code;

use Tao\Captcha\Core\Helper;

class SimpleCode extends AbstractCode
{
    private  $realCode;

    protected function asciiCode(): string
    {
        $length = config('tao.captcha.length');
        $code = Helper::shuffleString($this->num_config['chars'], $length[0], $length[1]);
        $this->realCode = strtoupper($code);
        return $code;
    }

    protected function nonAsciiCode(): string
    {
        $length = config('tao.captcha.length');
        $code = Helper::shuffleString($this->num_config['chars'], $length[0], $length[1]);
        $this->realCode = Helper::chineseNumToArabicNum($code);
        return $code;
    }

    protected function validationCode()
    {
        return $this->realCode;
    }
}
