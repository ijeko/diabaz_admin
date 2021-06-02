<?php

namespace App\Http\Controllers;

use App\Http\Sevices\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function createOrder(Request $request)
    {
        return $this->orderService->AddNewOrderWith($request->data);
        // TODO получить данные в виде сущности плана, передать их в сервис для обработки и записи в БД
    }

    public function showOrders (Request $request)
    {
        $status = $request->status;
        return $this->orderService->ShowOrdersWith($status);
        // TODO вернуть массив заявок в требуемом виде
    }

    public function showOrder ()
    {
        dd(__METHOD__);

        // TODO Вернуть объект заявки в нативном виде для дальнейшего изменения или удаления
    }

    public function editOrder ()
    {
        dd(__METHOD__);

        // TODO Полуичть новые данные в виде сушности плана и передать их в сервис для изменения записи в БД
    }

    public function deleteOrder ()
    {
        dd(__METHOD__);

        // TODO удалить заявку
    }

    public function AddNewStatus (Request $request)
    {
        return $this->orderService->SaveNewStatus($request->data);
    }

    public function GetStatuses ()
    {
        return $this->orderService->GetStatuses();
    }

    public function RemoveStatus (Request $request)
    {
        return $this->orderService->Remove('OrderStatus', $request->id);
    }

    public function EditStatus (Request $request)
    {
        return $this->orderService->EditStatus($request->data);
    }

    public function SetStatus(Request $request)
    {
        $order = $request->data;
        return $this->orderService->setStatusTo($order);
        //TODO реализовать функционал
    }

    public function SetPaymentStatus(Request $request)
    {;
        $order = $request->data;
        $this->orderService->SetPaymentTo($order);
    }

    public function addComment(Request $request)
    {
        $comment = $request->data;
        return $this->orderService->AddCommentToOrder($comment);
    }
}
