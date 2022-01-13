<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public    $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'transaction_id',
        'customer_name',
        'total_qty',
        'total_price',
        'created_at',
        'updated_at',
    ];
    // protected $dates = ['created_at'];
    protected $hidden = [];
    protected $casts = [];
}
