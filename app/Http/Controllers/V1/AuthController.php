<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business\V1\Auth\LoginBusiness;

class AuthController extends Controller
{
    public function login(Request $request, LoginBusiness $loginBusiness)
    {
        $auth = $loginBusiness->execute($request);

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
