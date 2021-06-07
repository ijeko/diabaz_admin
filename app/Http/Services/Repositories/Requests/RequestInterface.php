<?php


namespace App\Http\Services\Repositories\Requests;


use Illuminate\Database\Eloquent\Model;

interface RequestInterface

{
    public function __construct(int $id, array $params);

}
