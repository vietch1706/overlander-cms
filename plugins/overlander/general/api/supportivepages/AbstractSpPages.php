<?php

namespace Overlander\General\Api\SupportivePages;

use Overlander\General\Repository\SupportivePages as RepositorySupportivePages;

class AbstractSpPages
{

    public RepositorySupportivePages $spPage;
    public function __construct(RepositorySupportivePages $spPage)
    {

        $this->spPage = $spPage;
    }
}
