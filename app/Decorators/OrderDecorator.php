<?php


namespace App\Decorators;


use App\Builders\BuilderInterfaces\OrderBuilderInterface;
use App\Builders\OrderBuilder;
use App\Models\Order;

class OrderDecorator implements OrderBuilderInterface
{

    protected $builder;

    public function __construct(OrderBuilder $builder)
    {
        $this->builder = $builder;
    }


    public function InitiateExisting(Order $order)
    {
        // TODO: Implement InitiateExisting() method.
    }

    public function reset()
    {
        // TODO: Implement reset() method.
    }

    public function GetOrder ()
    {
        return $this->builder->GetOrder();
    }
}
