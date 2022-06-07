<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropLine extends Model
{
    protected $fillable = [
        'drop_id',
        'user_id',
        'time_line'
    ];

    protected $hidden = ['updated_at'];

    public function drop()
    {
        return $this->belongsTo(Drop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
