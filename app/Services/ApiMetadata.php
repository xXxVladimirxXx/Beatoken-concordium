<?php

namespace App\Services;

use App\Models\{Nft};
use Illuminate\Support\Facades\{Storage, Http};

class ApiMetadata
{
    public function createMetadata(Nft $nft, $nftData, $attributes = [])
    {
        try {
            $metadata = [
                'name' => $nftData['name'],
                'source_file' => Storage::disk('public')->url($nftData['uri_file']),
                'cover_image' => Storage::disk('public')->url($nftData['cover_image']),
                'external_url' => env('APP_URL') . '/nft/' . $nft->id,
                'description' => $nftData['description'],

                'nft_id' => (int) $nft->id
            ];

            if (isset($nftData['cover_video'])) $metadata['cover_video'] = Storage::disk('public')->url($nftData['cover_video']);
            if (isset($nftData['attachment_file'])) $metadata['attachment_file'] = Storage::disk('public')->url($nftData['attachment_file']);

            if ([] != $attributes) $metadata['attributes'] = $attributes;

            return Http::post(env('URL_API_TOKEN_METADATA') . 'metadata/store', $metadata);
        } catch (\Exception $e) {
            $nft->delete();
            return $e->getMessage();
        }
    }
}
