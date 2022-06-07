<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Auth;

class Drop extends Model
{
    protected $appends = ['full_uri'];

    protected $with = ['nfts', 'user'];

    protected $fillable = [
        'name',
        'user_id',
        'release_name',
        'release_start',
        'release_end',
        'price',
        'cover_image',
        'short_description',
        'full_description',
        'video_url',
        'number_nfts',
        'status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dropLines()
    {
        return $this->hasMany(DropLine::class);
    }

    public function nfts()
    {
        return $this->hasMany(Nft::class, 'drop_id');
    }

    public function getFullUriAttribute()
    {
        return $this->full_uri = Storage::disk('public')->url($this->cover_image);
    }
}