<?php

namespace Overlander\General\Api\SupportivePages;

use Illuminate\Http\Request;

class GetAll extends AbstractSpPages
{
    public function __invoke(Request $request): array
    {
        $param = $request->all();
        $result = null;
        if (!empty($param['slug'])) {
            $result = $this->spPage->getBySlug($param['slug']);
        } elseif (!empty($param['id'])) {
            $result = $this->spPage->getById($param['id']);
        } else {
            $result = $this->spPage->getAll();
        }
        if (empty($result)) {
            return [
                'message' => 'empty'
            ];
        }
        return $result;
    }
}
