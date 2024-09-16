<?php

namespace Legato\Api\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function getStatusCode()
    {
        return 404;
    }
}
