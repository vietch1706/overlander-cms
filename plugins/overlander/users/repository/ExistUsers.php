<?php

namespace Overlander\Users\Repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;
use Legato\Api\Exceptions\BadRequestException;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\Users\Models\Users;
use Overlander\Users\Repository\Users as RepositoryUsers;

class ExistUsers
{
    const BIRTH_QUESTION = 0;
    const EMAIL_QUESTION = 1;
    const MEMBERSHIP_QUESTION = 2;
    const PURCHASE_QUESTION = 3;
    const MEMBER_QUESTION = 4;
    const CODE_QUESTION = 5;
    const PHONE_QUESTION = 6;
    const NORMAL_MEMBER = 0;
    public Users $users;

    public function __construct(Users $user)
    {
        $this->users = $user;
    }

    public function step1($data)
    {
        switch ($data['question1']) {
            case 'email':
                $user = $this->users->where('email', $data['answer1'])->first();
                break;
            case 'phone':
                $user = $this->users->where('phone', $data['answer1'])->first();
                break;
            case 'member':
                $user = $this->users->where('member_no', $data['answer1'])->first();
                break;
        }
        if (empty($user)) {
            throw new NotFoundException(Lang::get('overlander.users::lang.user.not_found'));
        }
        if ($user['is_existing_member'] == self::NORMAL_MEMBER) {
            throw new BadRequestException(Lang::get('overlander.users::lang.exists_users.step1.not_exists'));
        } elseif ($data['question1'] === 'email') {
            RepositoryUsers::sendCode($data['answer1'], 'Transfer Member');
        }
        return [
            'message' => Lang::get('overlander.users::lang.exists_users.step1.next_step'),
        ];
    }

    public function getQuestions($previousQuestion)
    {
        $questions = [
            [
                'id' => self::BIRTH_QUESTION,
                'name' => 'When was year birth year and month?',
            ],
            [
                'id' => self::EMAIL_QUESTION,
                'name' => 'What is your email address?',
            ],
            [
                'id' => self::MEMBERSHIP_QUESTION,
                'name' => 'When did you join overlander membership?',
            ],
            [
                'id' => self::PURCHASE_QUESTION,
                'name' => 'When was your last purchase?',
            ],
            [
                'id' => self::MEMBER_QUESTION,
                'name' => 'What is your member no.?',
            ],
            [
                'id' => self::CODE_QUESTION,
                'name' => 'What is the access code?',
            ],
            [
                'id' => self::PHONE_QUESTION,
                'name' => 'What is your phone no.',
            ]
        ];
        array_splice($questions, $previousQuestion, 1);
        return $questions;
    }

    public function step2($params)
    {
        $question = $params['question2'];
        $answer = $params['answer2'];
        switch ($params['question1']) {
            case self::EMAIL_QUESTION:
                $user = $this->users->where('email', $params['answer1'])->first();
                break;
            case self::PHONE_QUESTION:
                $user = $this->users->where(DB::raw('concat(phone_area_code, phone)'), $params['answer1'])->first();
                break;
            case self::MEMBER_QUESTION:
                $user = $this->users->where('member_no', $params['answer1'])->first();
                break;
        }
        switch ($question) {
            case self::BIRTH_QUESTION:
                $answer = explode(' ', $answer);
                $year = $answer[0];
                $month = $answer[1];
                if ((string)$user['year'] !== $year || (string)$user['month'] !== $month) {
                    throw new BadRequestException(Lang::get('overlander.users::lang.exists_users.step2.failed'));
                }
                break;
            case self::EMAIL_QUESTION:
                if ($answer == $user['email']) {
                    RepositoryUsers::sendCode($answer, 'Transfer Member');
                }
                break;
            case self::MEMBERSHIP_QUESTION:
                $answer = str_replace(' ', '-', $answer);
                $answer = Carbon::createFromFormat('Y-m', $answer);
                if ($answer->diffInMonths($user['join_date']) != 0 && $answer->diffInYears($user['join_date']) != 0) {
                    throw new BadRequestException(Lang::get('overlander.users::lang.exists_users.step2.failed'));
                }
                break;
            case self::PURCHASE_QUESTION:
                $message = 'Verify success with last purchase';
                break;
            case self::MEMBER_QUESTION:
                if ($answer != $user['member_no']) {
                    throw new BadRequestException(Lang::get('overlander.users::lang.exists_users.step2.failed'));
                }
                break;
            case self::CODE_QUESTION:
                $message = 'Verify success with access code';
                break;
            case self::PHONE_QUESTION:
                if ($answer == $user['phone']) {
                    $message = 'Verify success with phone no';
                }
                break;
        }
        return [
            'message' => Lang::get('overlander.users::lang.exists_users.step2.success'),
        ];

    }
}
