<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Legato\Api\Helpers\RestHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Update extends AbstractUsers
{
    public function __invoke(Request $request): array
    {
        $params = $request->all();
        RestHelper::validate($params, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['required', 'numeric', 'regex:/[0-9]/', 'not_regex:/[a-z]/'],
            'password' => 'required',
            'country' => 'required',
            'email' => ['required', 'email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'],
        ]);
        $params['mail_receive'] = $params['mail_receive'] === 'true';
        $params['e_newsletter'] = $params['e_newsletter'] === 'true';
        return $this->users->update($params);
    }
}
