<?php

namespace Overlander\Transaction\Repository;

use function number_format;

class Transaction
{
    public static function convertData($transactionDetail)
    {
        $campaign = array_values((array)json_decode($transactionDetail->campaign));
        $multiplier = 0;
        if (!empty($campaign)) {
            foreach ($campaign as $key => $item) {
                $multiplier += $item->multiplier;
            }
        }
        return [
            'plc' => $transactionDetail->plc,
            'description' => $transactionDetail->description,
            'point' => number_format($transactionDetail->point),
            'quantity' => $transactionDetail->quantity,
            'price' => number_format($transactionDetail->price),
            'fprice' => number_format($transactionDetail->fprice),
            'discount' => $transactionDetail->discount,
            'multiplier' => $multiplier,
        ];
    }
}
