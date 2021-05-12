<?php


namespace App\Builders;


use App\Http\Sevices\DateParser;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class OrderBuilder implements BuilderInterfaces\OrderBuilderInterface
{
    protected $date;
    /**
     * @var Order
     */
    protected $order;

    public function __construct()
    {
        $this->reset();
        $this->date = Session::get('currentDate');
        $this->date = DateParser::Parse($this->date);
    }

    public function InitiateExisting(Order $order)
    {
        $this->order = $order;
    }

    public function BuildFullOrder()
    {
        $orderProduct = $this->order->product()->first()->title;
        $unit = $this->order->product()->first()->unit;

        $this->order->product = $orderProduct;
        $this->order->unit = $unit;
    }

    public function GetOrder()
    {
        $result = $this->order;
        $this->reset();

        return $result;
    }

    public function reset(): void
    {
        $this->order = new Order();
    }
}