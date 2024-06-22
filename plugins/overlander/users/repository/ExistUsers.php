<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Overlander\General\Helper\General;
use Overlander\General\Models\VerificationQuestions;
use Overlander\Users\Models\Users;

class ExistUsers
{

    const ACTIVE = 1;
    const NORMAL_MEMBER = 0;
    public Users $users;
    public VerificationQuestions $questions;

    public function __construct(Users $user, VerificationQuestions $question)
    {
        $this->users = $user;
        $this->questions = $question;
    }

    public function step1Code($data)
    {
        if (!empty($data['email'])) {
            $user = $this->users->where('email', $data['email'])->first();
        } elseif (!empty($data['phone'])) {
            $phone = str_replace(' ', '+', $data['phone']);
            $user = $this->users->where('phone', $phone)->first();
        } elseif (!empty($data['member_no'])) {
            $user = $this->users->where('member_no', $data['member_no'])->first();
        }
        if ($user['is_existing_member'] == self::NORMAL_MEMBER) {
            return [
                'message' => 'You are not a Existing Account. Please login!!!',
            ];
        }
        if (empty($data['phone']) && !empty($user)) {
            return [
                'message' => 'Continue step 2!!!',
            ];
        }
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
        $updateDatas = [
            'verification_code' => $code,
            'send_mail_at' => Carbon::now()->toDateTimeString(),
            'send_time' => $user['send_time'] + 1,
        ];
//        if (!empty($data['email'])) {
////            Mail::sendTo($user['email'], 'overlander.general::mail.exists_verify', ['code' => $code]);
//            $this->users->where('email', $user['email'])->update($updateDatas);
//            return [
//                'message' => 'Verify Code Have Been Sent to your mail!'
//            ];
//        } else {
        $this->users->where('phone', $user['phone'])->update($updateDatas);
        return [
            'message' => 'Verify Code Have Been Sent to your phone number!'
        ];
//        }
    }

    public function step2Questions($data)
    {
        if (!empty($data['phone']))
            $data['phone'] = str_replace(' ', '+', $data['phone']);
        $question = $this->questions->where('name', $data['question'])->first();
        $existUser = $this->users->where('phone', $data['phone'])->first();
        switch ($question['id']) {
            case 1:
                $data['year'] = explode(' ', $data['answer'])[0];
                $data['month'] = explode(' ', $data['answer'])[1];
                if ($existUser['year'] == $data['year'] && $existUser['month'] == $data['month']) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 3:
                $data['year'] = explode(' ', $data['answer'])[0];
                $data['month'] = explode(' ', $data['answer'])[1];
                dd($existUser);
                dd($existUser['active_date']);
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }
            case 2:
                if ($existUser['email'] == $data['email'] && empty($data['phone'])) {
                    $messages = [
                        'message' => 'Correct Information.'
                    ];
                }

        }
        dd($data);
    }

}
