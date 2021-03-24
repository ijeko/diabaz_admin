<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'user_id', 'date', 'soldTo', 'qty'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
