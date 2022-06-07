<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Collection extends Model
{
    protected $appends = ['full_uri_cover'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cover_image',
        'name',
        'description',
        'user_id'
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nfts()
    {
        return $this->hasMany(Nft::class);
    }

    public function getFullUriCoverAttribute()
    {
        return ($this->cover_image) ? $this->full_uri_cover = Storage::disk('public')->url($this->cover_image) : '';
    }
}
