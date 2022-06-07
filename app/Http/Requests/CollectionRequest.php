<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cover_image'    => 'required|file',
            'name'           => 'required|string|max:255',
            'description'    => 'required|string|max:255',
        ];
    }
}
