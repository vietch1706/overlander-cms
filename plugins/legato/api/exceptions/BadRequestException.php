<?php

namespace Legato\Api\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    public function getStatusCode()
    {
        return 400;
    }
}
