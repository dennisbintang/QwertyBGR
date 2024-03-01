<?php

namespace App\Business\V1\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateBusiness
{
    private $attributes = null;
    
    public $errors = [];

    public $valid = true;
    
    public $user = null;

    public function execute(Request $request)
    {
        $this->attributes = $request;

        $this->validate();

        if ($this->valid) $this->store();

        return $this;
    }

    private function validate()
    {
        $validator = Validator::make($this->attributes->all(), [
            'name' => 'required|min:6|max:100',
            'phone' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email|unique:users',
            'username' => 'required|min:6|max:50|unique:users',
            'password' => 'required|min:6|max:25|confirmed',
            'password_confirmation' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            $this->errors[] = $validator->errors()->first();
            $this->valid = false;
        }
    }

    private function store()
    {
        $field = $this->attributes->all();

        $this->user = new User;
        $this->user->name = $field['name'];
        $this->user->email = $field['email'];
        $this->user->username = $field['username'];
        $this->user->phone = $field['phone'];
        $this->user->password = Hash::make($field['password']);
        $this->user->role_id = $field['role_id'];
        $this->user->created_by = auth()->user()->id;
        $this->user->save();
    }
}
