<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIncome extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'material_id', 'qty', 'user_id'];


    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

}
