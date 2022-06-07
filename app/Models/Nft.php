<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Http, Cache};
use Auth;

class Nft extends Model
{
    protected $appends = ['metadata', 'extension_file'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token_uri',
        'price',
        'user_id',
        'drop_id',
        'latest_drop_id',
        'collection_id'
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drop()
    {
        return $this->belongsTo(Drop::class);
    }

    public function latestDrop()
    {
        return $this->belongsTo(Drop::class, 'latest_drop_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function getMetadataAttribute()
    {
        if ($this->token_uri && isset(parse_url($this->token_uri)['host']) && isset(parse_url($this->token_uri)['path'])) {
            $token_uri = $this->token_uri;
            return Cache::remember($this->token_uri, now()->addDays(1), function () use ($token_uri) {
                return json_decode(Http::get($token_uri)->body());
            });
        }
    }

    public function getExtensionFileAttribute()
    {
        if (!isset($this->metadata->source_file)) return null;
        return pathinfo($this->metadata->source_file)['extension'];
    }
}
