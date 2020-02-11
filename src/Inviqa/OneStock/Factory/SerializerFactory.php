<?php

namespace Inviqa\OneStock\Factory;

use Inviqa\OneStock\Normalizer\SkipEmptyPropertyNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    public function createSerializer(): Serializer
    {
        return new Serializer([new SkipEmptyPropertyNormalizer()], [new JsonEncoder()]);
    }
}
