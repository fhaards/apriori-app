<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public    $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'product_id',
        'name',
        'brand',
        'price',
        'stock',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
}
