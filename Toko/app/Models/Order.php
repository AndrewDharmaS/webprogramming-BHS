<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'orders';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $guarded = [];
    
    public function cart() {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
