<?php


namespace App\Http\Controllers;


use App\Http\Services\TransportTaxCalculator;
use Illuminate\Http\Request;

class TransportCalcController extends Controller
{
    protected $taxCalculator;

    public function __construct(TransportTaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }

    public function GetCityFromAti(Request $request)
    {
        return $this->taxCalculator->GetCityFromAti(json_encode($request->all()));
    }

    public function CalculateTexes(Request $request)
    {
        return $this->taxCalculator->CalculateTaxes($request->data['from'], $request->data['to']);
    }
}
