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
    const EXIST_MEMBER = 1;
    public Users $users;

    public function __construct(Users $user)
    {
        $this->users = $user;
    }

    public function step1($params)
    {
        try {
            $user = $this->users->where('is_existing_member', self::EXIST_MEMBER);
            switch ($params['question1']) {
                case 'email':
                    $user->where('email', $params['answer1']);
                    break;
                case 'phone':
                    $user->where(DB::raw('concat(phone_area_code, phone)'), $params['answer1']);
                    break;
                case 'member':
                    $user->where('member_no', $params['answer1']);
                    break;
            }
            $result = $user->first();
            if (empty($result)) {
                throw new NotFoundException(Lang::get('overlander.users::lang.user.not_found'));
            } elseif ($params['question1'] == 'email') {
                RepositoryUsers::sendCode($params['answer1'], 'Transfer Member');
            }
            return [
                'message' => Lang::get('overlander.users::lang.exists_users.step1.next_step'),
            ];
        } catch (\Exception $th) {
            throw new BadRequestException($th->getMessage());
        }

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
        $user = $this->users->where('is_existing_member', self::EXIST_MEMBER);
        switch ($params['question1']) {
            case self::EMAIL_QUESTION:
                $user->where('email', $params['answer1']);
                break;
            case self::PHONE_QUESTION:
                $user->where(DB::raw('concat(phone_area_code, phone)'), $params['answer1']);
                break;
            case self::MEMBER_QUESTION:
                $user->where('member_no', $params['answer1']);
                break;
        }
        switch ($question) {
            case self::BIRTH_QUESTION:
                $answer = explode(' ', $answer);
                $year = $answer[0];
                $month = $answer[1];
                $user->where('year', $year)->where('month', $month);
                break;
            case self::EMAIL_QUESTION:
                $user->where('email', $answer);
                break;
            case self::MEMBERSHIP_QUESTION:
                $answer = explode(' ', $answer);
                $year = $answer[0];
                $month = $answer[1];
                $user->whereYear('join_date', '=', $year)
                    ->whereMonth('join_date', '=', $month);
                break;
            case self::PURCHASE_QUESTION:
                $message = 'Verify success with last purchase';
                break;
            case self::MEMBER_QUESTION:
                $user->where('member_no', $answer);
                break;
            case self::CODE_QUESTION:
                $message = 'Verify success with access code';
                break;
            case self::PHONE_QUESTION:
                $user->where(DB::raw('concat(phone_area_code, phone)'), $answer);
                break;
        }
        $result = $user->first();
        if (!$result) {
            throw new NotFoundException(Lang::get('overlander.users::lang.exists_users.step2.failed'));
        }
        if ($answer == self::EMAIL_QUESTION) {
            RepositoryUsers::sendCode($result->email, 'Transfer Member');
        }
        return [
            'data' => RepositoryUsers::convertData($result),
        ];
    }
}
