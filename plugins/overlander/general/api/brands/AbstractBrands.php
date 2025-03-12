<?php

namespace Overlander\General\Api\Brands;

use Overlander\General\Repository\Brands as RepositoryBrands;

class AbstractBrands
{

    public RepositoryBrands $brand;
    public function __construct(RepositoryBrands $brand)
    {
        $this->brand = $brand;
    }
}
