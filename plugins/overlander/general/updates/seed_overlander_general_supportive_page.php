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
    const STATUS_ACTIVE = 1;

    public function run()
    {
        $supportivepages = [
            [
                'title' => 'Terms & Conditions',
                'contents' => '
        <p><br>
        <strong>The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.</strong><br>
        &nbsp;&nbsp;<br>
        <strong>1.&nbsp;Collection &amp; Adoption of Personal Information</strong><br>
        The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.<br>
        The information collected is used only by The Overlander for the purposes of sending promotion materials and related information via email, mailing of printed material, SMS message, Mobile App Push message etc. User location/region provided by member will be used for delivery of online purchase. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.<br>
        &nbsp;&nbsp;<br>
        <strong>2.&nbsp;</strong><strong>Security Mangement</strong><br>
        The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.<br>
        &nbsp;&nbsp;<br>
        <strong>3.&nbsp;Change of Personal Information</strong><br>
        You can update your personal information via one of the following method&nbsp;<br>
        1.Go to My Account&gt; Personal Details Section in The Overlander Membership App<br>
        2.Log into <a href="http://member.overlander.com.hk/en/" target="_blank">http://member.overlander.com.hk/en/</a>&nbsp;or <a href="https://www.overlander.com.hk/en/" target="_blank">https://www.overlander.com.hk/en/</a> and go to Profile Section<br>
        Fill in the change of information form at our shops.<br>
        &nbsp;&nbsp;<br>
        <strong>4.&nbsp;Delivery of E-Newsletter</strong><br>
        In order to provide latest Information of products, discounts, equipment guides to members, The Overlander sends out E-Newsletter at the beginning of each month to all registered email address. The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add <a href="mailto:mem@orientfair.com">mem@orientfair.com</a> to your contact list.<br>
        &nbsp;<br>
        <strong>5.&nbsp;</strong><strong>Unsubscribing From Email </strong>The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please&nbsp;<br>
        1.To stop receiving Email or printed material<br>
        Click the “Unsubscribe” button in the in-coming emails to unsubscribe, or e-mail to&nbsp;<a href="mailto:mem@orientfair.com">mem@orientfair.com</a></p> ~',
                'status' => self::STATUS_ACTIVE,
                'slug' => 'terms-and-conditions',
            ],
            [
                'title' => 'Privacy Policy',
                'contents' => '
                <p><br>
        <strong>The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.</strong><br>
        &nbsp;&nbsp;<br>
        <strong>1.&nbsp;Collection &amp; Adoption of Personal Information</strong><br>
        The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.<br>
        The information collected is used only by The Overlander for the purposes of sending promotion materials and related information via email, mailing of printed material, SMS message, Mobile App Push message etc. User location/region provided by member will be used for delivery of online purchase. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.<br>
        &nbsp;&nbsp;<br>
        <strong>2.&nbsp;</strong><strong>Security Mangement</strong><br>
        The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.<br>
        &nbsp;&nbsp;<br>
        <strong>3.&nbsp;Change of Personal Information</strong><br>
        You can update your personal information via one of the following method&nbsp;<br>
        1.Go to My Account&gt; Personal Details Section in The Overlander Membership App<br>
        2.Log into <a href="http://member.overlander.com.hk/en/" target="_blank">http://member.overlander.com.hk/en/</a>&nbsp;or <a href="https://www.overlander.com.hk/en/" target="_blank">https://www.overlander.com.hk/en/</a> and go to Profile Section<br>
        Fill in the change of information form at our shops.<br>
        &nbsp;&nbsp;<br>
        <strong>4.&nbsp;Delivery of E-Newsletter</strong><br>
        In order to provide latest Information of products, discounts, equipment guides to members, The Overlander sends out E-Newsletter at the beginning of each month to all registered email address. The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add <a href="mailto:mem@orientfair.com">mem@orientfair.com</a> to your contact list.<br>
        &nbsp;<br>
        <strong>5.&nbsp;</strong><strong>Unsubscribing From Email </strong>The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please&nbsp;<br>
        1.To stop receiving Email or printed material<br>
        Click the “Unsubscribe” button in the in-coming emails to unsubscribe, or e-mail to&nbsp;<a href="mailto:mem@orientfair.com">mem@orientfair.com</a></p> ',
                'status' => self::STATUS_ACTIVE,
                'slug' => 'privacy-policy',
            ],
            [
                'title' => 'Disclaimer',
                'contents' => '<p><br>
        <strong>The Overlander is committed to protect privacy. The Overlander will apply and comply with the laws and principals of the Personal Data (Privacy) Ordinance (Cap 486) of the Laws of Hong Kong and to safeguard the privacy of customers with respect to personal data.</strong><br>
        &nbsp;&nbsp;<br>
        <strong>1.&nbsp;Collection &amp; Adoption of Personal Information</strong><br>
        The Overlander will only collect, hold and use personal data required for its operations and other related activities, and in a lawful and fair manner.<br>
        The information collected is used only by The Overlander for the purposes of sending promotion materials and related information via email, mailing of printed material, SMS message, Mobile App Push message etc. User location/region provided by member will be used for delivery of online purchase. The personal information provided will not be transferred to any other parties which are irrelevant to The Overlander. The Overlander does not use your personal data for any other purposes without your prior consent unless such use is permitted or required by law.<br>
        &nbsp;&nbsp;<br>
        <strong>2.&nbsp;</strong><strong>Security Mangement</strong><br>
        The Overlander will maintain your personal data securely in our system. Only the authorized staffs will be permitted to access to these personal data. The Overlander will also ensure compliance by our staff with the strictest standards of security and confidentiality.<br>
        &nbsp;&nbsp;<br>
        <strong>3.&nbsp;Change of Personal Information</strong><br>
        You can update your personal information via one of the following method&nbsp;<br>
        1.Go to My Account&gt; Personal Details Section in The Overlander Membership App<br>
        2.Log into <a href="http://member.overlander.com.hk/en/" target="_blank">http://member.overlander.com.hk/en/</a>&nbsp;or <a href="https://www.overlander.com.hk/en/" target="_blank">https://www.overlander.com.hk/en/</a> and go to Profile Section<br>
        Fill in the change of information form at our shops.<br>
        &nbsp;&nbsp;<br>
        <strong>4.&nbsp;Delivery of E-Newsletter</strong><br>
        In order to provide latest Information of products, discounts, equipment guides to members, The Overlander sends out E-Newsletter at the beginning of each month to all registered email address. The E-Newsletter may sometimes be treated as spam or junk mail by public email servers like Yahoo, Gmail, Hotmail, Sina, etc. To ensure that you do not miss our email notification, please add <a href="mailto:mem@orientfair.com">mem@orientfair.com</a> to your contact list.<br>
        &nbsp;<br>
        <strong>5.&nbsp;</strong><strong>Unsubscribing From Email </strong>The Overlander may send direct marketing materials to all members or other customers who have participated in shop events, based on the personal data provided. If you do not want your personal data be used for the purpose of direct marketing, please&nbsp;<br>
        1.To stop receiving Email or printed material<br>
        Click the “Unsubscribe” button in the in-coming emails to unsubscribe, or e-mail to&nbsp;<a href="mailto:mem@orientfair.com">mem@orientfair.com</a></p> ',
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
