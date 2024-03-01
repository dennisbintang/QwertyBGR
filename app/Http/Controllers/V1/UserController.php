<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business\V1\User\CreateBusiness as userCreate;

class UserController extends Controller
{
    public function store(Request $request, userCreate $business)
    {
        $execute = $business->execute($request);

        if (!$execute->valid) {
            return response()->json(response_error($execute->errors), 400);
        }

        return response()->json(response_success($execute->user), 200);
    }
}
