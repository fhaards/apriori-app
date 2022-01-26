<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Products as PRD;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;

class AprioriHelpers
{
    public static function getAprioriTable($getArray)
    {
        $getArray = [];
        $qty      = [];
        $countProduct = 0;

        $listProduct = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');


        $listTransact2 = TRS::get();
        $loopProduct   = $listProduct->get();
        $countProduct  = $loopProduct->count() - 1;
        $cTrans       = $listTransact2->count();
        $listTransact  = TRS::get();

        foreach ($listTransact as $key => $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($loopProduct as $item) {
                $prodId = $item->id;
                $trans =  DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $item->id)
                    ->where('tr.transaction_id', '=', $tr->transaction_id)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($trans as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results[] = $qty;
                } else {
                    $results[] = 0;
                }

                $collection = collect($results);
            }
            $groups = $collection->split($cTrans);
            $groups->all();
        }

        foreach ($listTransact2 as $key => $tr) {
            $idtrans = $tr->transaction_id;
            $getArray[] = [
                $idtrans => $groups[$key],
            ];
        }
        // $getArray[] = [
        //     'count' => $cTrans,
        //     'data'  => [
        //         $idtrans => $groups
        //     ],
        // ];
        // echo json_encode($getArray);
        return $getArray;
    }
}
