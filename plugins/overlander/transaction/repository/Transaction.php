<?php

namespace Overlander\Transaction\Repository;

class Transaction
{
    public static function convertData($transaction)
    {
        return [
            'invoice_no' => 'Invoice ID #' . $transaction->invoice_no,
            'date' => $transaction->date,
            'total_fprice' => $transaction->detail->sum('fprice'),
        ];
    }
}
