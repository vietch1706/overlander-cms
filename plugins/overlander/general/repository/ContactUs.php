<?php

namespace Overlander\General\Repository;

use Overlander\General\Models\Contact;

class ContactUs
{
  public Contact $contact;

  public function __construct(Contact $contact)
  {
    $this->contact = $contact;
  }
}
