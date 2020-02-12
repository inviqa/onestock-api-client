<?php

namespace Inviqa\OneStock\Normalizer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SkipEmptyPropertyNormalizer extends ObjectNormalizer
{
    protected function isAllowedAttribute($classOrObject, $attribute, $format = null, array $context = [])
    {
        if (!parent::isAllowedAttribute($classOrObject, $attribute, $format, $context)) {
            return false;
        }

        return !in_array($this->getAttributeValue($classOrObject, $attribute), [null, []], true);
    }
}
