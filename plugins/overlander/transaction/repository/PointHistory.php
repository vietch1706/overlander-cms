<?php

namespace Overlander\Transaction\Repository;

use Backend\Facades\BackendAuth;
use Illuminate\Support\Facades\DB;
use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Repositories\Token;
use Overlander\Transaction\Models\PointHistory as ModelsPointHistory;
use Overlander\Transaction\Models\Transaction;
use Overlander\Users\Models\Users;
use function array_push;

class PointHistory
{
    public ModelsPointHistory $pointHistories;
    public Token $tokens;
    public Users $users;
    public Transaction $transactions;
    public function __construct(ModelsPointHistory $pointHistory, Token $token, Users $user, Transaction $transaction)
    {
        $this->pointHistories = $pointHistory;
        $this->tokens = $token;
        $this->users = $user;
        $this->transactions = $transaction;
    }

    public function convertData($pointHistory)
    {
        $user = $this->users->select('member_no', 'member_prefix')->find($pointHistory->user_id);

        return [
            'member_no' => $user->member_no . $user->member_prefix,
            'type' => $pointHistory->type,
            'amount' => $pointHistory->amount,
            'reason' => $pointHistory->reason,
            'expired_date' => $pointHistory->expired_date,
        ];
    }

    public function getByToken()
    {
        $user = BackendAuth::getUser();;
        $pointHistory = $this->users->find($user->id)->point_history;
        $convertData = [];
        foreach ($pointHistory as $pointHistoryItem) {
            $convertData[] = $this->convertData($pointHistoryItem);
        }
        if (empty($convertData)) {
            throw new NotFoundException(Lang::get('overlander.transaction::lang.point_history.not_found'));
        }
        return $convertData;
    }
}
