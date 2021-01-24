<?php

namespace App\Service\Transformer;


class ActivityTransformer extends BaseTransformer
{
    public function transform($object)
    {
        return unserialize($object);
    }
}
