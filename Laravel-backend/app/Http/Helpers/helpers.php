<?php

use Illuminate\Http\Request;

function verifyRecaptcha(Request $request)
{
    $result = [
        "success" => true,
        "errors" => [],
    ];
    $recaptchaResponse = $request->input('g-recaptcha-response');
    if (!$recaptchaResponse) {
        $result = [
            "success" => false,
            "errors" => ['recaptcha' => 'Captcha verification failed'],
        ];
        return $result;
    }

    $secretKey = env('RECAPTCHA_SECRET_KEY');
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success']) {
        $result = [
            "success" => false,
            "errors" => ['recaptcha' => 'Captcha verification failed'],
        ];
        return $result;
    }
    return $result;
}
function recaptchaStatus()
{
    return env("ENABLE_RECAPTCHA", false);
}
