<?php


namespace App\Http\Services\Repositories;


use App\Http\Services\Repositories\Requests\RequestInterface;

interface RepositoryInterface
{
    public function __construct(RequestInterface $request);

    function getAll();

    function getFiltered();

    function findById();

    function saveNew();

    function update();
}
