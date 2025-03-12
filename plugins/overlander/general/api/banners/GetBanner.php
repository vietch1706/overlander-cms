<?php

namespace Overlander\General\Api\Banners;

use Illuminate\Http\Request;

class GetBanner extends AbstractBanners
{

    public function __invoke(Request $request): array
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            return $this->banner->getById($param['id']);
        }
        return $this->banner->getAll();
    }
}
