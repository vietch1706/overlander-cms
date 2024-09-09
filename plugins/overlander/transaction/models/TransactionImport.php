<?php

namespace Overlander\Transaction\models;

use Backend\Models\ImportModel;
use Carbon\Carbon;
use Exception;

class TransactionImport extends ImportModel
{
    /**
     * @inheritDoc
     */
    public $rules = [
        'vip' => 'required',
        'name' => 'required',
        'plc' => 'numeric|required',
        'brand_code' => 'numeric|required',
        'description' => 'required',
        'invoice' => 'required',
        'date' => 'required',
        'quantity' => 'numeric|required',
        'unit' => 'required',
        'price' => 'numeric|required',
        'discount' => 'numeric|required',
        'fprice' => 'numeric|required',
        'shopid' => 'required',
        'category' => 'required',
        'loyalty_balance' => 'numeric|required',
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
                }
            } catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
            $transactionId = $transaction->id;
            try {
                $transactionDetail = new TransactionDetail();
                $transactionDetail->transaction_id = $transactionId;
                $transactionDetail->plc = $data['plc'];
                $transactionDetail->brand_code = $data['brand_code'];
                $transactionDetail->description = $data['description'];
                $transactionDetail->quantity = $data['quantity'];
                $transactionDetail->unit = $data['unit'];
                $transactionDetail->price = $data['price'];
                $transactionDetail->discount = $data['discount'];
                $transactionDetail->fprice = $data['fprice'];
                $transactionDetail->category = $data['category'];
                $transactionDetail->act01 = $data['act01'] === '' ? null : $data['act01'];
                $transactionDetail->act02 = $data['act02'] === '' ? null : $data['act02'];
                $transactionDetail->act03 = $data['act03'] === '' ? null : $data['act03'];
                $transactionDetail->act04 = $data['act04'] === '' ? null : $data['act04'];
                $transactionDetail->act05 = $data['act05'] === '' ? null : $data['act05'];
                $transactionDetail->act06 = $data['act06'] === '' ? null : $data['act06'];
                $transactionDetail->act07 = $data['act07'] === '' ? null : $data['act07'];
                $transactionDetail->act08 = $data['act08'] === '' ? null : $data['act08'];
                $transactionDetail->act09 = $data['act09'] === '' ? null : $data['act09'];
                $transactionDetail->act10 = $data['act10'] === '' ? null : $data['act10'];
                $transactionDetail->save();
                $this->logCreated();
            } catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
        PointHistory::upgradeMembership();
    }
}
