<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['table_id', 'status']; 
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
