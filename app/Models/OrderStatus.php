<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $fillable = ['status', 'color'];
    protected $orderNum;

    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function order()
    {
    }

    public function SetNumberOfOrders($orderNum)
    {
        $this->attributes = array_merge($this->attributes, ['orderNum' => $orderNum]);
    }
}
