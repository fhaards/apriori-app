<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Products as PRD;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;

class AprioriHelpers
{
    public static function getAprioriTable()
    {
        $getArray  = [];
        $qty       = [];
        $subqty    = [];
        $arrPrd    = [];

        $listProduct = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        $listTransact = TRS::orderBy('created_at', 'DESC')->get();
        $loopProduct  = $listProduct->get();

        $i = 0;
        foreach ($listTransact as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($loopProduct as $item) {
                $prodId = $item->id;
                $trans  = DB::table('transactions_lists as tr')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty');
                $sendToDatalist = $trans->get();
                foreach ($sendToDatalist as $val) {
                    $pIdTr    = $val->product_id;
                    $qty[]    = [$val->subtotal_qty];
                    $subqty[] = [$val->subtotal_qty];
                    $arrPrd[] = array($pIdTr);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }
            }
            $getArray[] = [
                $i => [
                    'prodId' => $prodId,
                    'qty' => $subqty,
                    'results' => $results
                ],
            ];
        }



        return $getArray;
    }
}
