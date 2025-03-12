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
        $contact = new $this->contact();
        $contact->name = $data['name'];
        $contact->email = $data['email'];
        $contact->title = $data['title'];
        $contact->reason = $data['reason'];
        $contact->message = $data['message'];
        $contact->save();
        return [
            'message' => Lang::get('overlander.general::lang.contact.sent'),
        ];
    }
}
