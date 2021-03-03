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
        return $this->belongsTo(Product::class);
    }
    public function material ()
    {
        return $this->hasMany(Material::class);
    }
}
