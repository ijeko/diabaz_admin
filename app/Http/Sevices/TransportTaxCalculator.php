<?php


namespace App\Http\Sevices;


use App\Exceptions\ZeroTransportTaxResultException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\This;

class TransportTaxCalculator
{
    protected $from;
    protected $to;
    protected $url;
    protected $query;

    public function __construct()
    {
        $this->url = 'https://trucks.ati.su/webapi/public/v1.0/trucks/search/';
        $this->query = 'excludeGeo=true';
    }

    public function CalculateTaxes($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
        $result = $this->AnalyzeData($this->CollectDataFromAllPages());
        if (is_numeric($result) && $result!=0){
            return $result;
        }
        else {
            $errorData = json_encode(['error' => 'По этому направлению нет предложений цены']);
            throw new ZeroTransportTaxResultException($errorData);
        }

    }


    public function GetCityFromAti($requestJson)
    {
        $jsonLength = strlen($requestJson);
        $atiClient = new Client([
            'headers' => [
                'base_uri' => 'https://trucks.ati.su/',
                'Content-Type' => 'application/json',
                'Content-Length' => $jsonLength,
                'Accept' => '*/*',
                'Host' => 'https://trucks.ati.su/',
            ],
        ]);
        $response = $atiClient->request('POST', 'https://trucks.ati.su/webapi/public/extendedsearch/v1/geo/', ['body' => $requestJson]);
        $body = $response->getBody();
        return $body->getContents();
    }


    private function PagesCount()
    {
        $pages_count = $this->PreRequest()['total_count'];
        return ceil($pages_count / 10);
    }

    private function PreRequest()
    {
        $body = $this->MakeRequestBody(1);
        $headers = $this->MakeHeaders($body);
        $atiClient = new Client([
            'headers' => $headers
        ]);
        $response = $atiClient->request('POST', $this->url, ['query' => $this->query, 'body' => $body]);
        $responseBody = $response->getBody();
        $result = json_decode($responseBody->getContents(), 1);
        return $result;
    }

    private function MainRequest($body, $headers)
    {
        $atiClient = new Client([
            'headers' => $headers
        ]);
        $response = $atiClient->request('POST', $this->url, ['query' => $this->query, 'body' => $body]);
        $responseBody = $response->getBody();
        $result = json_decode($responseBody->getContents(), 1);
        $result = collect($result['trucks']);
        $payments = $result->map(function ($item, $key) {
            return $item['payment'];
        });
        return $payments;
    }

    private function CollectDataFromAllPages()
    {
        $totalPayments = collect();
        $i = 0;
        while ($this->PagesCount() >= $i) {
            $i++;
            $body = $this->MakeRequestBody($i);
            $headers = $this->MakeHeaders($body);
            $totalPayments = $totalPayments->merge($this->MainRequest($body, $headers));
        }
        return $totalPayments;
    }

    private function MakeRequestBody($pageNumber)
    {
        $bodyObj = json_decode('{"page":1,"items_per_page":10,"filter":{"dates":{"date_option":"today-plus","date_from":"2021-05-26"},"from":{"id":170,"type":2,"exact_only":false},"to":{"id":3073,"type":2,"exact_only":false},"weight":{"min":20,"max":20},"with_rate":false,"truck_type":"1"}}');
        $bodyObj->filter->from = $this->from;
        $bodyObj->filter->to = $this->to;
        return json_encode($bodyObj);
    }

    private function MakeHeaders($body)
    {
        $cLength = strlen($body);
        $headers = [
            'base_uri' => 'https://trucks.ati.su/',
            'Content-Type' => 'application/json',
            'Content-Length' => $cLength,
            'Accept' => '*/*',
            'Host' => 'https://trucks.ati.su/',
        ];
        return $headers;
    }

    private function ValidateCityObject()
    {
    }

    private function AnalyzeData($data)
    {
        $modified = $data->map(function ($value, $key) {
            if ($value['cash_sum'] > 10000 || $value['sum_with_nds'] > 10000 || $value['sum_without_nds'] > 10000) {
                return $value;
            }
        });
        $dirtyCollection = $modified->flatten()->filter();
        $averageTax = $dirtyCollection->filter(function ($value, $key) {
            return is_numeric($value);
        })->avg();
        return ceil($averageTax);
    }

}
