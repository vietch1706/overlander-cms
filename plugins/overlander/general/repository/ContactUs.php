<?php

namespace Overlander\General\Repository;

use Lang;
use Overlander\General\Models\Contact;

class ContactUs
{
    public Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function add($data): array
    {
        $this->contact->name = $data['name'];
        $this->contact->email = $data['email'];
        $this->contact->title = $data['title'];
        $this->contact->reason = $data['reason'];
        $this->contact->message = $data['message'];
        $this->contact->save();
        return [
            'message' => Lang::get('overlander.general::lang.contact.sent'),
        ];
    }
}
