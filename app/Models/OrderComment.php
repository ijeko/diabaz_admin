<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderComment extends Model
{
    protected $
    use HasFactory;

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
