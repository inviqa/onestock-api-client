<?php

namespace Inviqa\OneStock\Factory;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    public function createSerializer(): Serializer
    {
        $arrayCallback = function ($innerObject) {
            return is_array($innerObject) && empty($innerObject) ? null : $innerObject;
        };

        return new Serializer([new ObjectNormalizer(null, null, null, null, null, null, [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractNormalizer::CALLBACKS => [
                'information' => $arrayCallback,
                'types' => $arrayCallback,
            ],
        ])], [new JsonEncoder()]);
    }
}
