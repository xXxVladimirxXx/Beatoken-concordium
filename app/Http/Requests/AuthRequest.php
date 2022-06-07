<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' =>    'required|email|max:255',
            'password' => 'required|string',
        ];
    }
}
