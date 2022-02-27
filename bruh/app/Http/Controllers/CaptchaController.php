<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CaptchaController extends Controller
{
    public function refreshCaptcha(): JsonResponse
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
