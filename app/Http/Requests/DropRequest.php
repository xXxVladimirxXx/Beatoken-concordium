<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'release_name' => 'required|string',
            'release_start' => 'required|date',
            'release_end' => 'required|date',
            'price' => 'required|numeric',
            'cover_image' => 'required|file',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'video_url' => 'string',
            'number_nfts' => 'required|string',
            'status' => 'string',
            'utc_user' => 'required'
        ];
    }
}
