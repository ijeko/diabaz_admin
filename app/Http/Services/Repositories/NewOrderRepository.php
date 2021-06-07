<?php


namespace App\Http\Services\Repositories;


use App\Http\Services\Repositories\Requests\RequestInterface;

class NewOrderRepository implements RepositoryInterface
{

    public function __construct(RequestInterface $request)
    {
    }

    function getAll()
    {
        // TODO: Implement getAll() method.
    }

    function getFiltered()
    {
        dd('NEW!');
        // TODO: Implement getFiltered() method.
    }

    function findById()
    {
        // TODO: Implement findById() method.
    }

    function saveNew()
    {
        // TODO: Implement saveNew() method.
    }

    function update()
    {
        // TODO: Implement update() method.
    }
}
