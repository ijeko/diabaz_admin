<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['status', 'color'];
    use HasFactory;

    public function order()
    {
        $this->belongsTo(Order::class, 'status', 'status');
    }
}
