<?php

namespace App\Service\Transformer;


class UserTransformer extends BaseTransformer
{
    public function transform($object)
    {
        return [
            'id' => (int)$object->id,
            'name' => (string)$object->name,
            'email' => (string)$object->email
        ];
    }
}
