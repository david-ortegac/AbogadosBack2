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
        return Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LdDy1kqAAAAAOo2FlMELbOQNWYZM1jHuY9V07Dy',
            'response' => $request->token
        ])->object();
    }
}
