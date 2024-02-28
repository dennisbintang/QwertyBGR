<?php

namespace App\Business\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginBusiness
{
    public $errors = [];
    public $user = null;
    public $token = null;
    public $valid = true;
    public $authenticated = false;
    private $attributes = null;

    public function __construct(Request $request)
    {
        $this->attributes = $request;

        $this->validate();

        $this->user();

        return $this;
    }

    private function validate()
    {
        $validator = Validator::make($this->attributes->all(), [
            'email' => 'required_if:username,0|email',
            'username' => 'required_if:email,0',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $this->errors[] = $validator->errors()->first();
            $this->valid = false;
        }
    }

    private function user()
    {
        if (!$this->valid) return;

        if ($this->attributes->has('email')) {
            $this->user = User::where(['email' => $this->attributes->email])->first();
        } else if ($this->attributes->has('username')) {
            $this->user = User::where(['username' => $this->attributes->username])->first();
        }

        if ($this->user == null || !Hash::check($this->attributes->password, $this->user->password)) {
            $this->errors[] = 'Invalid username / email address / password';

            return;
        }

        if ($token = $this->user->createToken($this->user->username)->plainTextToken) {
            $this->authenticated = true;
            $this->token = $token;
        } else {
            $this->errors[] = 'Login credentials is invalid';
        }
    }
}
