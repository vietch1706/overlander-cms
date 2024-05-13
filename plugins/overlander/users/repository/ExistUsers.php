<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Overlander\General\Helper\General;
use Overlander\Users\Models\Users;

class ExistUsers
{

  public Users $users;

  const ACTIVE = 1;
  const INACTIVE = 0;

  public function __construct(Users $user)
  {
    $this->users = $user;
  }
  public function step1Code($data)
  {
    dd($this->users->where('send_time', '=', 3)->first());
    $user = $this->users->getByEmail($data['email'])->first();

    if (Carbon::now()->diffInMinutes($user['send_mail_at']) < 10 && !empty($user['verification_code'])) {
      return [
        'message' => 'You Can Only Send Verification Code Once Each Ten Minutes!'
      ];
    }
    if ($user['send_time'] == 3) {
      return [
        'message' => 'You Can Send Code 3 times a day',
      ];
    }
    $code = General::generateRandomCode();
    Mail::sendTo($user['email'], 'overlander.general::mail.exists_verify', ['code' => $code]);
    $updateDatas = [
      'verification_code' => $code,
      'send_mail_at' => Carbon::now()->toDateTimeString(),
      'send_time' => $user['send_time'] + 1,
    ];
    $this->users->where('email', $user['email'])->update($updateDatas);
    return [
      'message' => 'Verify Code Have Been Sent to your mail!'
    ];
  }

  public function validationStep1($data)
  {
    $user = $this->users->getByEmail($data['email'])->first();
    if (Carbon::now()->diffInMinutes($user['send_mail_at']) > 10 && $data['code'] == $user['verification_code']) {
      $updateDatas = [
        'verification_code' => null,
        'send_mail_at' => null,
      ];
      $this->users->where('email', $user['email'])->update($updateDatas);
      return [
        'message' => 'Verification code expired!'
      ];
    }
    if ($data['code'] == $user['verification_code']) {
      $updateDatas = [
        'verification_code' => null,
        'send_mail_at' => null,
        'is_active' => self::ACTIVE,
        'active_date' => Carbon::now()->toDateTimeString(),
      ];
      $this->users->where('email', $user['email'])->update($updateDatas);
      return [
        'message' => 'Verify successfully!',
      ];
    }
    return [
      'message' => 'Wrong Code. Try Again!',
    ];
  }
}
