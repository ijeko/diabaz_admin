<?php


namespace App\Http\Services\Repositories;


use App\Http\Services\Repositories\Requests\RequestInterface;
use App\Models\Order;

class OrderRepository implements RepositoryInterface
{
    protected $request;
    protected $order;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
        $this->order = new Order();
    }

    function getAll()
    {
        return $this->order->all();
        // TODO: Implement getAll() method.
    }

    function getFiltered()
    {
        return $this->order->where($this->request->params)->get();
        // TODO: Implement getFiltered() method.
    }

    function findById()
    {
        return $this->order->find($this->request->id);
        // TODO: Implement findById() method.
    }

    function saveNew()
    {
        $this->order->fill($this->request->params);
        return $this->order->save();
        // TODO: Implement saveNew() method.
    }

    function update()
    {
        $this->order->update($this->request->params);
        // TODO: Implement update() method.
    }
}
