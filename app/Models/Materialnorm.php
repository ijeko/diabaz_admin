<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materialnorm extends Model
{
    use HasFactory;

    public function product ()
    {
        return $this->hasMany(Product::class);
    }
    public function material ()
    {
        return $this->hasMany(Material::class);
    }
}