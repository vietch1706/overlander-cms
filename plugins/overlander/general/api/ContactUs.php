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


  public function sendMessage(Request $request)
  {
    $data = $request->all();
    $rules = [
      'name' => 'required',
      'email' => 'required|email',
      'title' => 'required',
      'reason' => 'required|numeric|max:3',
      'message' => 'required',
    ];

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      throw new BadRequestHttpException('fail!!!');
    }
    try {
      Contact::insert(
        [
          'name' => $request->name,
          'email' => $request->email,
          'title' => $request->title,
          'reason' => $request->reason,
          'message' => $request->message,
        ],
      );
      return [
        "Save Successful!"
      ];
    } catch (Exception $th) {
      throw new BadRequestHttpException('fail!!!');
    }
  }
}
