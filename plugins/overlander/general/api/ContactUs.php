<?php

namespace Overlander\General\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Overlander\General\Models\Contact;
use Overlander\General\Repository\ContactUs as RepositoryContactUs;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContactUs
{
  public RepositoryContactUs $contact;
  public function __construct(RepositoryContactUs $contact)
  {
    $this->contact = $contact;
  }


  public function getAllMessages(Request $request)
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
