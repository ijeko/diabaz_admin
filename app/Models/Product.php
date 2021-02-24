<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function materialNorm ()
    {
        return $this->hasMany(Materialnorm::class);
    }
}
