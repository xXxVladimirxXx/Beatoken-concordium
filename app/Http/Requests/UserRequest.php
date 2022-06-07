<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' =>          'string|max:21',
            // 'email' =>      'email|max:255',
            'twitter_url' =>   'string|nullable',
            'instagram_url' => 'string|nullable',
            'facebook_url' =>  'string|nullable',
            'role_id' =>       'numeric',
            'first_name' =>    'string|max:21|nullable',
            'last_name' =>     'string|max:21|nullable',
            'country_code' =>  'string|max:2|nullable',
            'city' =>          'string|nullable',
            'address' =>       'string|nullable',
            'zip' =>           'numeric|nullable',
            'cell_сс' =>       'string|nullable',
            'cell_number' =>   'string|nullable'
        ];
    }
}
