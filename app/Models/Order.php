<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'shippingDate', 'client', 'qty', 'comment', 'status', 'isPaid', 'isShipped'];

    private $product_id;
    private $shippingDate;
    private $client;
    private $qty;
    private $status;
    private $isPaid;
    private $isShipped;
    private $user_id;


//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//        $this->attributes = ['user_id' => Auth::id(), 'isPaid' => false, 'isShipped' => false];
//    }

    //Getters
    public function GetId()
    {
        return $this->id;
    }
    public function GetProduct()
    {
        return $this->product_id;
    }

    public function GetShippingDate()
    {
        return $this->shippingDate;
    }

    public function GetClient()
    {
        return $this->client;
    }

    public function GetQuantity()
    {
        return $this->qty;
    }

    public function GetStatus()
    {
        return $this->status;
    }

    public function GetPaymentStatus()
    {
        return $this->isPaid;
    }

    public function GetShippingStatus()
    {
        return $this->isShipped;
    }

    public function GetUser()
    {
        return $this->user_id;
    }

    //Setters

    public function SetProduct($product_id)
    {
         $this->product_id = $product_id;
    }

    public function SetShippingDate($date)
    {
         $this->shippingDate = $date;
    }

    public function SetClient($client)
    {
         $this->client = $client;
    }

    public function SetQuantity($qty)
    {
         $this->qty = $qty;
    }

    public function SetStatus($status_id)
    {
         $this->status = $status_id;
    }

    public function SetPaymentStatus($isPaid)
    {
         $this->isPaid = $isPaid;
    }

    public function SetShippingStatus($isShipped)
    {
         $this->isShipped = $isShipped;
    }

    public function SetUser($user_id)
    {
         $this->user_id = $user_id;
    }


    //Relations
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
