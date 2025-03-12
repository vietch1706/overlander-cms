<?php

namespace Legato\Api\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function getStatusCode()
    {
        return 403;
    }
}
