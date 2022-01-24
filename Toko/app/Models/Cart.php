<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
    ];

    protected $guarded = [];

    public function user() {
        return $this->belongTo(User::class, 'id', 'user_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'cart_id', 'id');
    }

}
