<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produced extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'date', 'user_id', 'qty'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
