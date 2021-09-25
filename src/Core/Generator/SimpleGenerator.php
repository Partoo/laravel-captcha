<?php

namespace Tao\Captcha\Core\Generator;
/**
 * Simple generate s
 */
class SimpleGenerator extends AbstractGenerator implements IGenerator
{

    public function render($code, $params): array
    {
        $hexBgColor = $params['background'][mt_rand(0, count($params['background']) - 1)];
        $bgColor = $this->hex2Rgb($hexBgColor);

        $hexColors = $params['colors'][mt_rand(0, count($params['colors']) - 1)];
        $textColor = $this->hex2Rgb($hexColors);

        $img = imagecreatetruecolor($params['width'], $params['height']);
        imagefill($img, 0, 0, imagecolorallocate($img, $bgColor['r'], $bgColor['g'], $bgColor['b']));

        preg_match_all('/./u', $code['code'], $matches);
        $str_len = count($matches[0]);
        $x = ($params['width'] - $str_len * ($params['letterSpacing'] + $params['fontSize'] * 0.66)) / 2;
        for ($i = 0; $i < $str_len; $i++) {
            ImageTTFtext(
                $img,
                $params['fontSize'],
                0,
                $x,
                ceil(($params['height'] + $params['fontSize']) / 2),
                imagecolorallocate($img, $textColor['r'], $textColor['g'], $textColor['b']),
                $params['font'],
                $matches[0][$i]
            );
            $x += ceil($params['fontSize'] * 0.66) + $params['letterSpacing'];
        }

        for ($i = 0; $i < $params['scratches'][0]; $i++) {
            $this->drawScratch($img, $params['width'], $params['height'], $hexColors);
        }

        for ($i = 0; $i < $params['scratches'][1]; $i++) {
            $this->drawScratch($img, $params['width'], $params['height'], $hexBgColor);
        }

        ob_start();
        imagepng($img);
        $content = ob_get_contents();
        ob_end_clean();
        imagedestroy($img);

        return [
            'image' => $content,
            'validation' => $code['validationCode']
        ];
    }
}
