<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function createOrder()
    {
        dd(__METHOD__);
        // TODO получить данные в виде сущности плана, передать их в сервис для обработки и записи в БД
    }

    public function showOrders ()
    {
        return view('plans');

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
}
