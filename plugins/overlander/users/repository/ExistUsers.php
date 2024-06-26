<?php

namespace Overlander\Users\Repository;

use Lang;
use Overlander\Users\Models\Users;
use Overlander\Users\Repository\Users as RepositoryUsers;

class ExistUsers
{
    const EMAIL_QUESTION = 2;
    const PHONE_QUESTION = 7;
    const MEMBER_QUESTION = 5;
    const BIRTH_QUESTION = 1;
    const MEMBERSHIP_QUESTION = 3;
    const PURCHASE_QUESTION = 4;
    const CODE_QUESTION = 6;

    const ACTIVE = 1;
    const NORMAL_MEMBER = 0;
    public Users $users;

    public function __construct(Users $user)
    {
        $this->users = $user;
    }

    public function step1($data)
    {
        switch (array_keys($data)[0]) {
            case 'email':
                $user = $this->users->where('email', $data['email'])->first();
                if ($user['is_existing_member'] != self::NORMAL_MEMBER) {
                    RepositoryUsers::sendCode($data['email'], 'Transfer Member');
                }
                break;
            case 'phone':
                $phone = str_replace(' ', '+', $data['phone']);
                $user = $this->users->where('phone', $phone)->first();
                break;
            case 'member_no':
                $user = $this->users->where('member_no', $data['member_no'])->first();
                break;
        }
        if (!empty($user)) {
            return [
                'message' => Lang::get('overlander.users::lang.exists_users.step1.not_found'),
            ];
        }
        if ($user['is_existing_member'] == self::NORMAL_MEMBER) {
            return [
                'message' => Lang::get('overlander.users::lang.exists_users.step1.not_exists'),
            ];
        }
        return [
            'message' => Lang::get('overlander.users::lang.exists_users.step1.next_step'),
        ];
    }

    public function getQuestions($previousQuestion)
    {
        $questions = [
            self::BIRTH_QUESTION => 'When was year birth year and month?',
            self::EMAIL_QUESTION => 'What is your email address?',
            self::MEMBERSHIP_QUESTION => 'When did you join overlander membership?',
            self::PURCHASE_QUESTION => 'When was your last purchase?',
            self::MEMBER_QUESTION => 'What is your member no.?',
            self::CODE_QUESTION => 'What is the access code?',
            self::PHONE_QUESTION => 'What is your phone no.?'
        ];
        unset($questions[$previousQuestion]);
        return $questions;
    }

    public function step2($param)
    {
        $question = $param['question'];
        $answer = $param['answer'];
        $method = array_keys($param)[2];
        $message = null;
        switch ($method) {
            case 'email':
                $user = $this->users->where('email', $param['email'])->first();
                break;
            case 'phone':
                $phone = str_replace(' ', '+', $method);
                $user = $this->users->where('phone', $param['phone'])->first();
                break;
            case 'member_no':
                $user = $this->users->where('member_no', $param['member_no'])->first();
                break;
        }
        switch ($question) {
            case 1:
                $answer = explode(' ', $answer);
                $year = $answer[0];
                $month = $answer[1];
                if ($user['year'] == $year && $user['month'] == $month) {
                    $message = 'Verify success with birthdate';
                }
                break;
            case 2:
                if ($answer == $user['email']) {
                    RepositoryUsers::sendCode($answer, 'Transfer Member');
                }
                break;
            case 3:
                $message = 'Verify success with membership joint date';
                break;
            case 4:
                $message = 'Verify success with last purchase';
                break;
            case 5:
                if ($answer == $user['member_no']) {
                    $message = 'Verify success with member no';
                }
                break;
            case 6:
                $message = 'Verify success with access code';
                break;
            case 7:
                if ($answer == $user['phone']) {
                    $message = 'Verify success with phone no';
                }
                break;
        }
        return [
            'message' => $message,
        ];
    }
}
