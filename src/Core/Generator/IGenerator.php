<?php

namespace Tao\Captcha\Core\Generator;

interface IGenerator
{
    /**
     * 渲染验证码图片
     * @param $code
     * @param $params
     * @return string|bool
     */
    public function render($code, $params): array;
}
