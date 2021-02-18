<?php


namespace App\Http\Sevices;


use App\Models\Produced;

class ProducedService
{
    private $produced;

    public function __construct(Produced $produced)
    {
        $this->produced = $produced;
    }

    public function get()
    {
        return $this->produced->get()->where('product_id', '=', 5);
    }
}
