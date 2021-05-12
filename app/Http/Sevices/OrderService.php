<?php


namespace App\Http\Sevices;


use App\Builders\OrderBuilder;
use App\Models\Order;

class OrderService extends Service
{
    public function GetAllOrdersOfMonth()
    {
        $builder = new OrderBuilder();
        $orders = collect();
        foreach (Order::all() as $order)
        {
            $builder->InitiateExisting($order);
            $builder->BuildFullOrder();
            $orderItem = $builder->GetOrder();
            $orders->push($orderItem);
        }
        return $orders;
    }
}