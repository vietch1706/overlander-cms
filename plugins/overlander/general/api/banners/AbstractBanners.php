<?php

namespace Overlander\General\Api\Banners;
use Overlander\General\Repository\Banners as RepositoryBanner;

class AbstractBanners
{

    public RepositoryBanner $banner;

    public function __construct(RepositoryBanner $banner)
    {
        $this->banner = $banner;
    }
}
