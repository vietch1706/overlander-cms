<?php

namespace Overlander\General\Api\Countries;

use Overlander\General\Repository\Country as RepositoryCountry;

class AbstractCountries
{
    public RepositoryCountry $countries;

    public function __construct(RepositoryCountry $country)
    {

        $this->countries = $country;
    }
}
