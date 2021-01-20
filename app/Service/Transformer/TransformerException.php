<?php


namespace App\Service\Transformer;

class TransformerException extends \Exception
{
    public function __construct($message = "Transformer's transformCollection requires Collection or Paginator instance.")
    {
        parent::__construct($message, 500);
    }
}
