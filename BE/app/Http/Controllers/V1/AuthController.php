<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $auth = new \App\Business\V1\Auth\LoginBusiness($request);

        if (!$auth->authenticated) {
            return response()->json(response_error($auth->errors), 401);
        }

        $respose = response_success([
            array_merge($auth->user->toArray(), ['token' => $auth->token])
        ]);

        return response()->json($respose, 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(response_success());
    } 
}
