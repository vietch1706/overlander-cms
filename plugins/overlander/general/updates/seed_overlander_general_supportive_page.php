<?php

namespace Overlander\General\Updates;

use Overlander\General\Models\Supportivepages;
use Seeder;

/**
 * SupportivePageSeeders
 */
class SeedOverlanderGeneralSupportivePage extends Seeder
{
  /**
   * run the database seeds.
   */
  public function run()
  {

    $supportivepages =  [
      [
        'title' => 'Terms & Conditions',
        'contents' => 'The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.

            1. Collection & Adoption of Personal Information
            The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.
            The information collected is used only by The Overlander for the purposes of sending promotion materials and related information including e-newsletters. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.

            2. Security Mangement
            The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.

            3. Change of Personal Information
            You can update your personal information via http://member.overlander.com.hk/en
            Or fill in the change of information form at our shops.

            4. Delivery of E-Newsletter
            The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add master@orientfair.com to your contact list. Creating contacts

            5. Unsubscribing From Email
            The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please advise The Overlander in writing or by e-mail: mem@orientfair.com
            You may also click the “Unsubscribe”button in the in-coming emails to unsubscribe.',
        'status' => 1,
        'slug' => 'terms-and-conditions',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'title' => 'Privacy Policy',
        'contents' => 'The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.

    1. Collection & Adoption of Personal Information
    The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.
    The information collected is used only by The Overlander for the purposes of sending promotion materials and related information including e-newsletters. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.

    2. Security Mangement
    The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.

    3. Change of Personal Information
    You can update your personal information via http://member.overlander.com.hk/en
    Or fill in the change of information form at our shops.

    4. Delivery of E-Newsletter
    The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add master@orientfair.com to your contact list. Creating contacts

    5. Unsubscribing From Email
    The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please advise The Overlander in writing or by e-mail: mem@orientfair.com
    You may also click the “Unsubscribe”button in the in-coming emails to unsubscribe.',
        'status' => 1,
        'slug' => 'privacy-policy',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
      [
        'title' => 'Disclaimer',
        'contents' => 'The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.

    1. Collection & Adoption of Personal Information
    The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.
    The information collected is used only by The Overlander for the purposes of sending promotion materials and related information including e-newsletters. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.

    2. Security Mangement
    The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.

    3. Change of Personal Information
    You can update your personal information via http://member.overlander.com.hk/en
    Or fill in the change of information form at our shops.

    4. Delivery of E-Newsletter
    The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add master@orientfair.com to your contact list. Creating contacts

    5. Unsubscribing From Email
    The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please advise The Overlander in writing or by e-mail: mem@orientfair.com
    You may also click the “Unsubscribe”button in the in-coming emails to unsubscribe.',
        'status' => 1,
        'slug' => 'disclaimer',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ],
    ];
    Supportivepages::insert($supportivepages);
  }
}
