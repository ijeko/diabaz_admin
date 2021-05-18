<?php


namespace App\Http\Sevices;


use App\Builders\OrderBuilder;
use App\Decorators\OrderCommentsGetter;
use App\Decorators\OrderStatusColored;
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
            $statusDecorator = new OrderStatusColored($builder);
//            dd($statusDecorator);
            $commentsDecorator = new OrderCommentsGetter($statusDecorator);
            $orderItem = $commentsDecorator->GetOrder();
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

    public function EditStatus($params)
    {
        $validatedParams = $this->ValidateInput($params)->validated();
        return OrderStatus::find($params['id'])->update($validatedParams);
    }

    public function SetStatusTo($order)
    {
        return Order::find($order['id'])->update(['status' => $order['status']]);
    }

    protected function ValidateInput(array $data)
    {
        return Validator::make($data, [
            'status' => ['required', 'string', 'regex:/(^([а-яА-Я ]+)(\d+)?$)/u', 'min:2', 'max:30']
        ]);
    }
}
