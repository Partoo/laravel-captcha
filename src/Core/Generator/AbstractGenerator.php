<?php

namespace Tao\Captcha\Core\Generator;

class AbstractGenerator
{
    private $colorCache = [];

    protected function hex2Rgb($hex): array
    {
        if (! isset($this->colorCache[$hex])) {
            $this->colorCache[$hex] = [
                'r' => hexdec(substr($hex, 0, 2)),
                'g' => hexdec(substr($hex, 2, 2)),
                'b' => hexdec(substr($hex, 4, 2))
            ];
        }

        return $this->colorCache[$hex];
    }

    protected function drawScratch($img, $imageWidth, $imageHeight, $hex)
    {
        $rgb = $this->hex2Rgb($hex);

        imageline(
            $img,
            mt_rand(0, floor($imageWidth / 2)),
            mt_rand(1, $imageHeight),
            mt_rand(floor($imageWidth / 2), $imageWidth),
            mt_rand(1, $imageHeight),
            imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b'])
        );
    }
}
