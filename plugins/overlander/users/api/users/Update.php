<?php

namespace Overlander\Users\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Update extends AbstractUsers
{
    public function __invoke(Request $request): array
    {
        $param = $request->all();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['unique:overlander_users_users,phone'],
            'password' => 'required',
            'country' => 'required',
            'email' => ['email', 'regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', 'unique:overlander_users_users,email'],
        ];

        $customMessages = [
            'phone.regex' => 'The phone number is already existed.',
            'email.regex' => 'The email address is already existed.',
        ];

        $validator = Validator::make($param, $rules, $customMessages);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->messages()->first());
//            return [
//                'code' => new BadRequestException,
//                'message' => $validator->messages()->first(),
//            ];
        }
        return $this->users->create($param);

    }
}
