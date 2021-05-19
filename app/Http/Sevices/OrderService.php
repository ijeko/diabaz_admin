<?php


namespace App\Http\Sevices;


use App\Builders\OrderBuilder;
use App\Decorators\OrderCommentsGetter;
use App\Decorators\OrderStatusColored;
use App\Models\Order;
use App\Models\OrderComment;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Validator;

class OrderService extends Service
{
    public function GetAllOrdersOfMonth()
    {
        $builder = new OrderBuilder();
        $statusDecorator = new OrderStatusColored($builder);
        $commentsDecorator = new OrderCommentsGetter($builder);
        $orders = collect();
        foreach (Order::all() as $order) {
            $statusDecorator->InitiateExisting($order);
            $statusDecorator->BuildFullOrder();
            $commentsDecorator->InitiateExisting($statusDecorator->GetOrder());
            $orders->push($commentsDecorator->GetOrder());
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

    public function SaveNewStatus($data)
    {
        $params = ['required', 'string', 'regex:/(^([а-яА-Я ]+)(\d+)?$)/u', 'min:2', 'max:30'];
        $validatedStatus = $this->ValidateInput($data, $params)->validated();
        return OrderStatus::firstOrCreate($validatedStatus);
    }

    public function EditStatus($data)
    {
        $params = ['required', 'string', 'regex:/(^([а-яА-Я ]+)(\d+)?$)/u', 'min:2', 'max:30'];
        $validatedParams = $this->ValidateInput($data, $params)->validated();
        return OrderStatus::find($params['id'])->update($validatedParams);
    }

    public function SetStatusTo($order)
    {
        return Order::find($order['id'])->update(['status' => $order['status']]);
    }

    public function AddCommentToOrder($comment)
    {
        $params = [['required', 'string',  'min:2', 'max:500']];
        $validatedData = $this->ValidateInput($comment, $params)->validated();
        return OrderComment::firstOrCreate($validatedData);
    }
    protected function ValidateInput(array $data, array $params)
    {
        return Validator::make($data, [
            key($data) => $params
        ]);
    }
}
