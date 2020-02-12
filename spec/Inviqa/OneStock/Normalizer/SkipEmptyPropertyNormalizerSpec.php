<?php

namespace spec\Inviqa\OneStock\Normalizer;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Serializer;

class SkipEmptyPropertyNormalizerSpec extends ObjectBehavior
{
    function it_disallows_empty_attributes()
    {
        $this->setSerializer(new Serializer());
        $this->normalize($this->createSubject())->shouldBe(['good' => 123, 'alsoGood' => 'lorem ipsum']);
    }

    private function createSubject()
    {
        return new class {
            public $good = 123;
            public $alsoGood = 'lorem ipsum';
            public $bad = null;
            public $alsoBad = [];
        };
    }
}
