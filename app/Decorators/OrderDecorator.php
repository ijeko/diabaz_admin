<?php


namespace App\Decorators;


use App\Builders\BuilderInterfaces\OrderBuilderInterface;
use App\Builders\OrderBuilder;
use App\Models\Order;

class OrderDecorator implements OrderBuilderInterface
{

    protected $orderBuilder;

    public function __construct(OrderBuilder $orderBuilder)
    {
        $this->orderBuilder = $orderBuilder;
    }


    public function InitiateExisting(Order $order)
    {
        $this->orderBuilder->InitiateExisting($order);
    }

    public function BuildFullOrder()
    {
        $this->orderBuilder->BuildFullOrder();
    }

    public function reset()
    {
        // TODO: Implement reset() method.
    }

    public function GetOrder()
    {
        return $this->orderBuilder->GetOrder();
    }
}
