<?php

namespace Overlander\Transaction\Repository;

use Backend\Facades\BackendAuth;
use Carbon\Carbon;
use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Legato\Api\Repositories\Token;
use Overlander\General\Helper\General;
use Overlander\General\Models\MembershipTier;
use Overlander\Transaction\Models\PointHistory as ModelsPointHistory;
use Overlander\Transaction\Models\Transaction;
use Overlander\Users\Models\Users;
use function number_format;
use function str_replace;
use function strtolower;
use function substr;

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

    public function getByToken()
    {
        $user = BackendAuth::getUser();

        if (!$user) {
            throw new NotFoundException(Lang::get('overlander.users::lang.user.not_found'));
        }

        $pointHistory = $this->users->find($user->id)->point_history;
        if (!$pointHistory) {
            throw new NotFoundException(Lang::get('overlander.transaction::lang.point_history.not_found'));
        }
        $convertData = [];
        foreach ($pointHistory as $pointHistoryItem) {
            $convertData[] = $this->convertData($pointHistoryItem);
        }
        return $convertData;
    }

    public function convertData($pointHistory)
    {
        $user = $this->users->select('member_no', 'member_prefix')->find($pointHistory->user_id);
        $transaction = '';
        $date = '';
        $invoice_no = '';
        $totalFprice = '';
        $logo = null;
        if ($pointHistory->type == $this->pointHistories::TYPE_GAIN) {
            $transaction = $pointHistory->transaction;
            $amount = '+' . number_format($pointHistory->amount) . 'pt.';
            $invoice_no = 'Invoice ID #' . $transaction->invoice_no;
            $totalFprice = $transaction->detail->sum('fprice');
            $date = 'Expire at ' . Carbon::create($pointHistory->expired_date)->format('d M Y');
        } else {
            $amount = '-' . number_format($pointHistory->amount) . 'pt.';
            $date = 'Upgraded at ' . Carbon::create($pointHistory->created_at)->format('d M Y');
            $last_word_start = strrpos($pointHistory->reason, ' ') + 1;
            $membershipSlug = strtolower(str_replace(".", "", substr($pointHistory->reason, $last_word_start)));
            $membershipTier = MembershipTier::select('logo')
                ->where('slug', $membershipSlug)
                ->first();
            if (!$membershipTier) {
                $logo = null;
            } else {
                $logo = General::getBaseUrl() . $membershipTier->logo;
            }
            if ($pointHistory->is_used == $this->pointHistories::IS_USED_UNUSABLE) {
                $date = 'Expire at ' . Carbon::create($pointHistory->expired_date)->format('d M Y');
            }
        }
        return [
            'member_no' => $user->member_no . $user->member_prefix,
            'type' => $pointHistory->type,
            'amount' => $amount,
            'reason' => $pointHistory->reason,
            'invoice_no' => $invoice_no,
            'total_fprice' => ' $' . $totalFprice,
            'logo' => $logo,
            'date' => $date,
        ];
    }
}
