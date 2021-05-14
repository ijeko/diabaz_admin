<?php


namespace App\Http\Sevices;


use App\Builders\OrderBuilder;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Validator;

class OrderService extends Service
{
    public function GetAllOrdersOfMonth()
    {
        $builder = new OrderBuilder();
        $orders = collect();
        foreach (Order::all() as $order) {
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

    public function GetStatuses ()
    {
        return OrderStatus::all();
    }

    public function SaveNewStatus($status)
    {
        $validatedStatus = $this->ValidateInput($status)->validated();
        return OrderStatus::firstOrCreate($validatedStatus);
    }

    protected function ValidateInput(array $data)
    {
        return Validator::make($data, [
            'status' => ['required', 'string', 'regex:/(^([а-яА-Я]+)(\d+)?$)/u', 'min:2', 'max:10']
        ]);
    }
}
