<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $appends = ['full_uri_avatar'];

    protected $with = ['role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'fee_sale_drop',
        'fee_sale_marketplace',
        'avatar_url',

        // user info
        'first_name',
        'last_name',
        'country_code',
        'city',
        'address',
        'zip',
        'cell_cc',
        'cell_number',

        'role_id',
        'twitter_url',
        'instagram_url',
        'facebook_url',

        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function nfts()
    {
        return $this->hasMany(Nft::class);
    }

    public function drop()
    {
        return $this->hasMany(Drop::class);
    }

    public function getFullUriAvatarAttribute()
    {
        return ($this->avatar_url) ? $this->full_uri_avatar = Storage::disk('public')->url($this->avatar_url) . '?' . date_timestamp_get(date_create()) : url('/') . '/assets/img/default-avatar.svg';
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
