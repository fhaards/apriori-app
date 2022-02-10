<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Products as PRD;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;

class TransactionsHelpers
{
    public static function countTotalTrans()
    {
        $getdata = TRS::count();
        return $getdata;
    }

    public static function getTransByDate($getDate)
    {
        $getData = TRS::whereDate('created_at', "=", $getDate)->get();
        return $getData;
    }

    public static function getTransByDateFull($getDate)
    {
        $dataTrans = [];
        $dataList = [];
        $dataComb = [];
        
        // SELECT AN ARRAY IN DB
        $findData = TRS::whereDate('created_at', "=", $getDate)->get();

        foreach ($findData as $v) {
            $thisID = $v->transaction_id;
            $findData2 = DB::table('transactions_lists as trl')
                ->leftJoin('products as prd', 'trl.product_id', '=', 'prd.id')
                ->where('transaction_id', '=', $thisID)
                ->get();

            $dataTrans[] = [
                'transid' => $v->transaction_id
            ];

            foreach ($findData2 as $key => $v2) {
                $dataList[$key] = [
                    'items' => $v2->name,
                    'subqty' => $v2->subtotal_qty,
                    'subprc' => 'Rp ' . number_format($v2->subtotal_price, 0),
                ];
            }

            $dataComb[] = [
                $thisID => $dataList,
            ];
        }

        return $dataComb;
    }
}
