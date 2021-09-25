<?php

namespace Tap\Captcha\Tests;

use Tao\Captcha\Core\Helper;
use Tests\TestCase;

class CaptchaTest extends TestCase
{
    public function testCnNum2ArabicNum()
    {
      $str = "九五三七八一";
      $result = Helper::chineseNumToArabicNum($str);
      $this->assertEquals('953781', $result);
    }

    public function testCurrentChars() {
        $str = config('tao.captcha.numberType.chars');
        $this->assertSame('一二三四五六七八九',$str);
    }

}
