<?php

namespace App\Exceptions;

use Exception;

class ZeroTransportTaxResultException extends Exception
{
    public function report(): bool
    {
        // Determine if the exception needs custom reporting...

        return false;
    }
    public function render($request)
    {
        return response($this->getMessage(), 400);
    }

}
