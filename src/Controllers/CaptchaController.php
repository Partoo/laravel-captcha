<?php

namespace Tao\Captcha\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Tao\Captcha\Facades\Captcha;

class CaptchaController extends Controller
{
    public function image(): \Illuminate\Http\JsonResponse
    {
        $image = Captcha::getImage();
        return response()->json([
            'image' => "data:image/png;base64," . base64_encode($image['image']),
            'validation' => $image['validation']
        ]);
    }

    public function validate(Request $request): \Illuminate\Http\JsonResponse
    {
        $key = $request->input('key');
        $result = $request->input('result');
        $success = Captcha::validate($key, $result);
        if ($success) {
            // Store the key to cache in 5 minutes, You can use it for next step.
            // EXAMPLE: Before send SMS, you can check the key existence, if not then reject the request.
            Cache::put($key, 'passed', now()->addMinutes(5));

            return response()->json([
                'message' => trans('tao.captcha::message.captcha_success'),
                'status' => 201,
            ]);
        }
        return response()->json([
            'message' => trans('tao.captcha::message.captcha_error'),
            'status' => 422
        ], 422);
    }
}
