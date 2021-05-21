<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'shippingDate', 'client', 'qty', 'comment', 'status', 'isPaid'];
    private $user_id;
    private $isPaid;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes = ['user_id' => Auth::id(), 'isPaid' => 0];
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderComment::class, 'order_id');
    }
}
