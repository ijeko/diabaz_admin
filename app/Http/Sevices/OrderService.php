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

    public function AddNewOrderWith($params)
    {
        $builder = new OrderBuilder();
        $order = $builder->GetOrder();
        $order->fill($params);
//        dd($order, $params);
        return $order->save();
    }
}
