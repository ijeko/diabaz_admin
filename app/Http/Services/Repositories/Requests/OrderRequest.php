<?php


namespace App\Http\Services\Repositories\Requests;


class OrderRequest implements RequestInterface
{
    public $id;
    public $params;

    /**
     * OrderRequest constructor.
     * @param int|null $id
     * @param array $params
     */
    public function __construct(int $id=null, array $params)
    {
        $this->id = $id;
        $this->params = $params;
    }
}
