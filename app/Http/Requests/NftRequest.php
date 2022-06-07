<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NftRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'            => 'required|string|max:255',
            'file'            => 'required|file',
            'cover_image'     => 'required|file',
            'cover_video'     => 'file',
            'description'     => 'required|string',
            'type'            => 'string',
            'attachment'      => 'string',
            'attachment_file' => 'file',
            'author'          => 'string',
            'creator'         => 'string',
            'creator_avatar'  => 'file',
            'collection_id'   => 'numeric',
            'copies'          => 'numeric',
            'price'           => 'numeric'
        ];
    }
}
