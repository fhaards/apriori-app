<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactions_list extends Model
{
    use HasFactory;

    protected $table = 'transactions_lists';
    public $timestamps = false;
    protected $fillable = [
        'transaction_id',
        'product_id',
        'subtotal_qty',
        'subtotal_price'
    ];
    // protected $dates = ['created_at'];
    protected $hidden = [];
    protected $casts = [];
}
