<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'shippingDate', 'client', 'qty', 'comment','isConfirmed', 'isSuccess'];
    private $user_id;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
