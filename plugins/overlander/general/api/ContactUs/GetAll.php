<?php

namespace Overlander\General\Api\ContactUs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetAll extends AbstractContactUs
{


    public function __invoke(Request $request): array
  {
    $data = $request->all();
    $rules = [
      'name' => 'required',
      'email' => 'required|email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
      'title' => 'required',
      'reason' => 'required|numeric|max:3',
      'message' => 'required',
    ];

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      throw new BadRequestHttpException($validator->messages()->first());
    }
    return $this->contact->add($data);
  }
}
