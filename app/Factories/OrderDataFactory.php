<?php


namespace App\Factories;


use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class OrderDataFactory implements DTOFactory
{

    public function FromRequest($dataArray)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = json_encode($dataArray);
        $order = new Order();

        $serializer->deserialize($data, Order::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $order]);
        dd($order);
//        return new Order([
//            'product_id' => $request->get('prouduct_id'),
//            'shippingDate' => $request->get('shippingDate'),
//            'qty' => $request->get('qty'),
//            'user_id' => $request->user()->id,
//            'client' => $request->get('client'),
//            'status' => $request->get('status'),
//            'isPaid' => $request->get('isPaid'),
//            'isShipped' => $request->get('isShipped')
//        ]);
    }
}
