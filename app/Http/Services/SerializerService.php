<?php


namespace App\Http\Services;


use Doctrine\DBAL\Connection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerService
{
    private $encoders;
    private $normalizers;
    private $serializer;

    public function __construct()
    {

        $this->encoders = [new JsonEncoder()];
        $this->normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    public function Serialize(Model $model)
    {
        return $model->toJson();

    }

    public function Deserialize($data, Model $object): Model
    {
        $this->serializer->deserialize($data, get_class($object), 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $object]);
        return $object;
    }
}
