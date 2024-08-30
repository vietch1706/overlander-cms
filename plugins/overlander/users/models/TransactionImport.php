<?php

namespace Overlander\Users\Models;

use Backend\Models\ImportModel;

class TransactionImport extends ImportModel
{
    /**
     * @inheritDoc
     */
    public $rules = [
    ];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            try {
                $transaction = new Transaction();
                $transaction->vip = $data['vip'];
                $transaction->name = $data['name'];
                $transaction->plc = $data['plc'];
                $transaction->description = $data['description'];
                $transaction->invoice = $data['invoice'];
                $transaction->date = $data['date'];
                $transaction->quantity = $data['quantity'];
                $transaction->unit = $data['unit'];
                $transaction->price = $data['price'];
                $transaction->discount = $data['discount'];
                $transaction->fprice = $data['fprice'];
                $transaction->shop_id = $data['shop_id'];
                $transaction->category = $data['category'];
                $transaction->loyal_balance = $data['loyal_balance'];
                $transaction->save();

            } catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
