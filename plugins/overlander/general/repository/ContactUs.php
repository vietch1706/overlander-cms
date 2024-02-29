<?php

namespace Overlander\General\Repository;

use Exception;
use Illuminate\Http\Request;
use Overlander\General\Models\Contact;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContactUs
{
  public Contact $contact;

  public function __construct(Contact $contact)
  {
    $this->contact = $contact;
  }

  public function add($data)
  {
    try {
      Contact::insert(
        [
          'name' => $data['name'],
          'email' => $data['email'],
          'title' => $data['title'],
          'reason' => $data['reason'],
          'message' => $data['message'],
        ],
      );
      return [
        'message' => "Save Successful!"
      ];
    } catch (Exception $th) {
      throw new BadRequestHttpException($th->getMessage());
    }
  }
}
