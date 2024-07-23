<?php

namespace Overlander\General\Api\SupportivePages;

use Illuminate\Http\Request;

class GetAll
{
    public function __invoke(Request $request): array
    {
//        $param = $request->all();
//        $result = null;
//        if (!empty($param['slug'])) {
//            $result =  $this->spPage->getBySlug($param['slug']);
//        } elseif (!empty($param['id'])) {
//            $result = $this->spPage->getById($param['id']);
//        } else {
//            return $this->spPage->getAll();
//        }
//        if (empty($result)) {
//            return [
//                'message' => 'empty'
//            ];
//        }
        return ['hehe'];
    }
}
