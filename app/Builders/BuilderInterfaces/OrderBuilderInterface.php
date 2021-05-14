<?php


namespace App\Builders\BuilderInterfaces;


use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

interface OrderBuilderInterface
{
    public function InitiateExisting (Order $order);

    public function reset();

    public function GetOrder();

}
