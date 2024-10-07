<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function validateCaptcha(Request $request): ?object
    {
        return Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LeiAlkqAAAAACCu8AI-Uf1TvS_2BHLPewBFKV14',
            'response' => $request
        ])->object();
    }
}
