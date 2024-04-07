<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_category_id',
        'transaction',
        'quantity',
        'date',
        'remark',
        'balance'
    ];

    // Define relationship with StockCategory
    public function category()
    {
        return $this->belongsTo(StockCategory::class, 'stock_category_id');
    }
}
