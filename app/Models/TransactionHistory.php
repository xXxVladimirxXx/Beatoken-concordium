<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    protected $table = 'transactions_history';

    protected $fillable = [
        'description',
        'amount',
        'type',
        'date',
        'orderId',
        'details',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
