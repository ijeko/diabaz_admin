<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderComment extends Model
{
    protected $username;
    protected $date;
    protected $fillable = ['comment', 'order_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes = ['username' => Auth::user()->name, 'date' => Carbon::now()->format('Y-m-d')];

    }

    use HasFactory;

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
