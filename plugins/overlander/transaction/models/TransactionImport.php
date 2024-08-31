<?php

namespace Overlander\Transaction\Models;

use Backend\Models\ImportModel;
use Carbon\Carbon;
use Exception;

class TransactionImport extends ImportModel
{
    /**
     * @inheritDoc
     */
    public $rules = [
    ];

    public function importData($results, $sessionKey = null)
    {
        $invoice = null;
        $transactionId = null;
        foreach ($results as $row => $data) {
            try {
                if ($invoice != $data['invoice']) {
                    $invoice = $data['invoice'];
                    $transaction = new Transaction();
                    $transaction->vip = $data['vip'];
                    $transaction->name = $data['name'];
                    $transaction->invoice_no = $data['invoice'];
                    $transaction->date = Carbon::createFromFormat('d/m/Y', $data['date'])->toDate();
                    $transaction->shop_id = $data['shop_id'];
                    $transaction->loyalty_balance = $data['loyalty_balance'];
                    $transaction->save();
                    $transactionId = $transaction->id;
                }
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transactionId;
                $transactionDetail->plc = $data['plc'];
                $transactionDetail->description = $data['description'];
                $transactionDetail->quantity = $data['quantity'];
                $transactionDetail->unit = $data['unit'];
                $transactionDetail->price = $data['price'];
                $transactionDetail->discount = $data['discount'];
                $transactionDetail->brand_code = 1;
                $transactionDetail->fprice = $data['fprice'];
                $transactionDetail->category = $data['category'];
                $transactionDetail->save();
                $this->logCreated();
            } catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
