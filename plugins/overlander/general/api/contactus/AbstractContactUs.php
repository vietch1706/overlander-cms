<?php

namespace Overlander\General\Api\ContactUs;

use Overlander\General\Repository\ContactUs as RepositoryContactUs;

class AbstractContactUs
{

    public RepositoryContactUs $contact;
    public function __construct(RepositoryContactUs $contact)
    {
        $this->contact = $contact;
    }
}
