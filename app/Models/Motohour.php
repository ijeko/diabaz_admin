<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motohour extends Model
{
    protected $fillable = ['machine_id', 'date', 'qty', 'user_id'];

    use HasFactory;
}
