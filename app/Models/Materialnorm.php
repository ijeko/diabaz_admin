<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materialnorm extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'norma', 'product_id', 'material_id'];

    public function product ()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function material ()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
