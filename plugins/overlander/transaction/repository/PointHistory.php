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
use Overlander\Transaction\Repository\Transaction as RepositoryTransaction;
use Overlander\Users\Models\Users;
use function array_push;
use function number_format;
use function str_replace;
use function strrpos;
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

    public function getList($limit, $page, $type)
    {
        $user = BackendAuth::getUser();

        if (!$user) {
            throw new NotFoundException(Lang::get('overlander.users::lang.user.not_found'));
        }

        $pointHistory = $this->pointHistories->where('user_id', $user->id)
            ->where('is_hidden', ModelsPointHistory::IS_HIDDEN_FALSE);

        if ($type == ModelsPointHistory::TYPE_GAIN) {
            $pointHistory = $pointHistory->where('type', ModelsPointHistory::TYPE_GAIN);
        } elseif ($type == ModelsPointHistory::TYPE_LOSS) {
            $pointHistory = $pointHistory->where('type', ModelsPointHistory::TYPE_LOSS);
        }
        $pointHistory = $pointHistory->paginate($limit, $page);
        if (empty($pointHistory->first())) {
            throw new NotFoundException(Lang::get('overlander.transaction::lang.point_history.not_found'));
        }
        foreach ($pointHistory as $key => $pointHistoryItem) {
            $pointHistory[$key] = $this->convertData($pointHistoryItem);
        }
        return $pointHistory;
    }

    public function convertData($pointHistory)
    {
        $user = $this->users->select('member_no', 'member_prefix')
            ->find($pointHistory->user_id);
        $date = '';
        $invoice_no = '';
        $totalFprice = '';
        $logo = null;
        $transactionDetail = null;
        $campaign = null;
        $transactionDate = null;
        if ($pointHistory->type == $this->pointHistories::TYPE_GAIN) {
            $transaction = $pointHistory->transaction;
            $amount = number_format($pointHistory->amount);
            $invoice_no = $transaction->invoice_no;
            $totalFprice = $transaction->detail->sum('fprice');
            $date = Carbon::create($pointHistory->expired_date)->format('d M Y');
            $transactionDetail = $transaction->detail;
            $campaign = $transaction->campaign;
            $transactionDate = Carbon::create($transaction->date)->format('d M Y');
            foreach ($transactionDetail as $key => $transactionDetailItem) {
                $transactionDetail[$key] = RepositoryTransaction::convertData($transactionDetailItem);
            }
        } else {
            $amount = number_format($pointHistory->amount);
            $date = Carbon::create($pointHistory->created_at)->format('d M Y');

        }
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
        return [
            'type' => $pointHistory->type,
            'amount' => $amount,
            'reason' => $pointHistory->reason,
            'invoice_no' => $invoice_no,
            'total_fprice' => $totalFprice,
            'logo' => $logo,
            'transaction_date' => $transactionDate,
            'history_date' => $date,
            'campaign' => $campaign,
            'detail' => $transactionDetail,
        ];
    }
}
