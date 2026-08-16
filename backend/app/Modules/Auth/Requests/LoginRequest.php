<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {


    public function rules() {

        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];

    }


    public function messages()
    {
        return [
            // Messages for email
            'email.required' => 'Your email is required',
            'email.email' => 'Your format of email is invalid',
            'email.unique' => 'This email is already registered',

            // Messages for password
            'password.required' => 'Your password is required',
            'password.min' => 'Password must be at least 8 characters',
        ];
    }

}