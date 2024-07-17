<?php

namespace Legato\Api\Helpers;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RestHelper
{
    public static function validate(array $params, array $rules, array $messages = []): void
    {
        $validator = Validator::make($params, $rules, $messages);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag()->getMessages();
            $messages = array_values($messages);
            $messages = array_map(static function ($value) {
                return implode(' ', $value);
            }, $messages);

            throw new BadRequestHttpException(implode(' | ', $messages));
        }
    }
}
