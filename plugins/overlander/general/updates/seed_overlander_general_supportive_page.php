<?php

namespace Overlander\General\Updates;

use Carbon\Carbon;
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

  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE   = 1;

  public function run()
  {
    $supportivepages =  [
      [
        'title' => 'Terms & Conditions',
        'contents' => '
        <p>
        The Overlander is committed to protect privacy. The Overlander will
        apply and comply with the laws <br />
        and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the
        Laws of Hong Kong and to safeguard the <br />
        privacy of customers with respect to personal data. <br />
        <br />1. Collection & Adoption of Personal Information <br />
        The Overlander will only collect, hold and use personal data required
        for its operations and other related <br />
        activities, and in a lawful and fair manner.<br />
        The information collected is used only by The Overlander for the
        purposes of sending promotion materials <br />and related information
        including e-newsletters. The personal information provided will not be
        transferred to <br />any other parties which are irrelevant to The
        Overlander. The Overlander does not use your personal data for<br />
        any other purposes without your prior consent unless such use is
        permitted or required by law. <br /><br />2. Security Mangement<br />
        The Overlander will maintain your personal data securely in our system.
        Only the authorized staffs will be <br />permitted to access to these
        personal data. The Overlander will also ensure compliance by our staff
        with the<br />
        strictest standards of security and confidentiality.<br />
        <br />3. Change of Personal Information<br />
        You can update your personal information via
        http://member.overlander.com.hk/en <br />Or fill in the change of
        information form at our shops. <br /><br />4. Delivery of E-Newsletter
        <br />The E-Newsletter may sometimes be treated as spam or junk mail by
        public email servers like Yahoo, Gmail, <br />Hotmail, Sina, etc. To
        ensure that you do not miss our email notification, please add
        master@orientfair.com to <br />your contact list. Creating contacts
        <br /><br />5. Unsubscribing From Email <br />The Overlander may send
        direct marketing materials to all members or other customers who have<br />
        participated in shop events, based on the personal data provided. If you
        do not want your personal data be <br />used for the purpose of direct
        marketing, please advise The Overlander in writing or by e-mail:
        <br />mem@orientfair.com <br />You may also click the
        “Unsubscribe”button in the in-coming emails to unsubscribe.<br />
      </p>',
        'status' => self::STATUS_ACTIVE,
        'slug' => 'terms-and-conditions',
      ],
      [
        'title' => 'Privacy Policy',
        'contents' => '<p>
        The Overlander is committed to protect privacy. The Overlander will
        apply and comply with the laws <br />
        and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the
        Laws of Hong Kong and to safeguard the <br />
        privacy of customers with respect to personal data. <br />
        <br />1. Collection & Adoption of Personal Information <br />
        The Overlander will only collect, hold and use personal data required
        for its operations and other related <br />
        activities, and in a lawful and fair manner.<br />
        The information collected is used only by The Overlander for the
        purposes of sending promotion materials <br />and related information
        including e-newsletters. The personal information provided will not be
        transferred to <br />any other parties which are irrelevant to The
        Overlander. The Overlander does not use your personal data for<br />
        any other purposes without your prior consent unless such use is
        permitted or required by law. <br /><br />2. Security Mangement<br />
        The Overlander will maintain your personal data securely in our system.
        Only the authorized staffs will be <br />permitted to access to these
        personal data. The Overlander will also ensure compliance by our staff
        with the<br />
        strictest standards of security and confidentiality.<br />
        <br />3. Change of Personal Information<br />
        You can update your personal information via
        http://member.overlander.com.hk/en <br />Or fill in the change of
        information form at our shops. <br /><br />4. Delivery of E-Newsletter
        <br />The E-Newsletter may sometimes be treated as spam or junk mail by
        public email servers like Yahoo, Gmail, <br />Hotmail, Sina, etc. To
        ensure that you do not miss our email notification, please add
        master@orientfair.com to <br />your contact list. Creating contacts
        <br /><br />5. Unsubscribing From Email <br />The Overlander may send
        direct marketing materials to all members or other customers who have<br />
        participated in shop events, based on the personal data provided. If you
        do not want your personal data be <br />used for the purpose of direct
        marketing, please advise The Overlander in writing or by e-mail:
        <br />mem@orientfair.com <br />You may also click the
        “Unsubscribe”button in the in-coming emails to unsubscribe.<br />
      </p>',
        'status' => self::STATUS_ACTIVE,
        'slug' => 'privacy-policy',
      ],
      [
        'title' => 'Disclaimer',
        'contents' => '<p>
        The Overlander is committed to protect privacy. The Overlander will
        apply and comply with the laws <br />
        and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the
        Laws of Hong Kong and to safeguard the <br />
        privacy of customers with respect to personal data. <br />
        <br />1. Collection & Adoption of Personal Information <br />
        The Overlander will only collect, hold and use personal data required
        for its operations and other related <br />
        activities, and in a lawful and fair manner.<br />
        The information collected is used only by The Overlander for the
        purposes of sending promotion materials <br />and related information
        including e-newsletters. The personal information provided will not be
        transferred to <br />any other parties which are irrelevant to The
        Overlander. The Overlander does not use your personal data for<br />
        any other purposes without your prior consent unless such use is
        permitted or required by law. <br /><br />2. Security Mangement<br />
        The Overlander will maintain your personal data securely in our system.
        Only the authorized staffs will be <br />permitted to access to these
        personal data. The Overlander will also ensure compliance by our staff
        with the<br />
        strictest standards of security and confidentiality.<br />
        <br />3. Change of Personal Information<br />
        You can update your personal information via
        http://member.overlander.com.hk/en <br />Or fill in the change of
        information form at our shops. <br /><br />4. Delivery of E-Newsletter
        <br />The E-Newsletter may sometimes be treated as spam or junk mail by
        public email servers like Yahoo, Gmail, <br />Hotmail, Sina, etc. To
        ensure that you do not miss our email notification, please add
        master@orientfair.com to <br />your contact list. Creating contacts
        <br /><br />5. Unsubscribing From Email <br />The Overlander may send
        direct marketing materials to all members or other customers who have<br />
        participated in shop events, based on the personal data provided. If you
        do not want your personal data be <br />used for the purpose of direct
        marketing, please advise The Overlander in writing or by e-mail:
        <br />mem@orientfair.com <br />You may also click the
        “Unsubscribe”button in the in-coming emails to unsubscribe.<br />
      </p>',
        'status' => self::STATUS_ACTIVE,
        'slug' => 'disclaimer',
      ],
    ];
    foreach ($supportivepages as $key => $value) {
      # code...
      $supportivepage = new Supportivepages();
      $supportivepage->title = $value['title'];
      $supportivepage->contents = $value['contents'];
      $supportivepage->status = $value['status'];
      $supportivepage->slug = $value['slug'];
      $supportivepage->created_at = Carbon::now();
      $supportivepage->updated_at = Carbon::now();
      $supportivepage->save();
    }
  }
}
