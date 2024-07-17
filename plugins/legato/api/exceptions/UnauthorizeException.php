<?php

namespace Legato\Api\Exceptions;

use Exception;

class UnauthorizeException extends Exception
{
    public function getStatusCode()
    {
        return 401;
    }
}
