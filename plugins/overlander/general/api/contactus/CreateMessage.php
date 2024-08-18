<?php

namespace Overlander\General\Api\ContactUs;

use Illuminate\Http\Request;
use Legato\Api\Helpers\RestHelper;

class CreateMessage extends AbstractContactUs
{
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'name' => 'required',
            'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
            'title' => 'required',
            'reason' => 'required|numeric|between:1,3',
            'message' => 'required',
        ]);
        return $this->contact->add($params);
    }

}
