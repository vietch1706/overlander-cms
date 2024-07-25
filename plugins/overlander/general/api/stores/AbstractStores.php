<?php

namespace Overlander\General\Api\Stores;

use Overlander\General\Repository\Stores as RepositoryStores;

class AbstractStores
{
    public RepositoryStores $stores;
    public function __construct(RepositoryStores $stores)
    {

        $this->stores = $stores;
    }

}
