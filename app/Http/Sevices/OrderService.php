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
    protected $textRus;
    protected $texEng;
    protected $textRusEng;

    public function __construct()
    {
        $this->textRus = ['required', 'string', 'regex:/(^([а-яА-Я ]+)(\d+)?$)/u', 'min:2', 'max:30'];
        $this->textRusEng = ['required', 'string', 'min:2', 'max:500'];
    }

    public function GetAllOrdersOfMonth()
    {
        $builder = new OrderBuilder();
        $statusDecorator = new OrderStatusColored($builder);
        $commentsDecorator = new OrderCommentsGetter($builder);
        $orders = collect();
        $orderModels = new Order();
        foreach ($orderModels->latest()->get() as $order) {
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
        $order->status = OrderStatus::first()->id;
        return $order->save();
    }

    public function GetStatuses()
    {
        return OrderStatus::all();
    }

    public function SaveNewStatus($data)
    {
        $dataArray=['status'=> $data['status']];
        $params = [$this->textRus];
        $validatedStatus = $this->ValidateInput($dataArray, $params)->validated();
        return OrderStatus::firstOrCreate($validatedStatus);
    }

    public function EditStatus($data)
    {
        $dataArray=['status'=> $data['status'], 'color'=> $data['color']];
        $params = [$this->textRus, $this->textRusEng];
        $validatedParams = $this->ValidateInput($dataArray, $params)->validated();
        return OrderStatus::find($data['id'])->update($validatedParams);
    }

    public function SetStatusTo($order)
    {
        return Order::find($order['id'])->update(['status' => $order['status']]);
    }

    public function AddCommentToOrder($comment)
    {
        $dataArray=['comment'=> $comment['comment']];
        $params = [['required', 'string', 'min:2', 'max:500']];
        $validatedData = $this
            ->ValidateInput($dataArray, $params)
            ->validated();
        $newComment = new OrderComment();
        $newComment->fill($validatedData)->save();
    }

    protected function ValidateInput(array $data, array $params)
    {
        $dataArray =[];
        $i=-1;
        foreach ($data as $key)
        {
            $i++;
            $dataArray = array_merge( $dataArray, [array_keys($data)[$i] => $params[$i]]);
        }
        return Validator::make($data, $dataArray);
    }
}
