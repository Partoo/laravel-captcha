<?php

namespace Tao\Captcha\Core;
class Helper
{
    /**
     * Generate random chars from specify string
     * @param $str
     * @param $min
     * @param $max
     * @return string
     */
    public static function shuffleString($str, $min, $max): string
    {
        $len = mt_rand($min, $max);
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $char_pos = mt_rand(0, mb_strlen($str) - 1);
            $result .= mb_substr($str, $char_pos, 1);
        }
        return $result;
    }

    /**
     * Convert Chinese-numbers to Arabic-numbers
     * @param $str
     * @return string
     */
    public static function chineseNumToArabicNum($str): string
    {
        preg_match_all('/./u', config('captcha.codeType.chars'), $map);
        $len = count($map[0]);
        $list = [];
        for ($i = 0; $i < $len; $i++) {
            $list[$i + 1] = $map[0][$i];
        }

        preg_match_all('/./u', $str, $matches);

        $result = [];
        foreach ($matches[0] as $match) {
            $result[] = array_search($match, $list);
        }
        return implode('', $result);
    }


}

