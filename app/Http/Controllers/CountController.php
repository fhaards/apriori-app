<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products as PRD;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\GlobalHelpers as GLBHelp;
use DateTime;

class CountController extends Controller
{
    public function revenueSource()
    {
        $findDataList = null;
        $totalList = 0;
        $data = [];

        $findDataList = DB::table('transactions_lists as tr')
            ->select(DB::raw('prd.id as prod_id,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty, 
                            SUM(tr.subtotal_price) as subprice'))
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->groupBy('prd.id')
            ->groupBy('prd.type')
            ->orderBy('subprice', 'DESC')
            ->limit('3')
            ->get();

        // $findDataList = DB::table('products as prd')
        //                 ->select(DB::raw('prd.product_id as prod_id,prd.name'))
        //                 ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty, 
        //                     SUM(tr.subtotal_price) as subprice'))
        //                 ->join('transactions_lists as tr', 'prd.product_id','=','tr.product_id')
        //                 ->groupBy('prd.product_id')
        //                 ->groupBy('prd.name')
        //                 ->orderBy('subprice', 'DESC')
        //                 ->limit('3')
        //                 ->get();

        foreach ($findDataList as $dtlist) :
            $data[] = [
                'product_id'   => $dtlist->prod_id,
                'product_name' => $dtlist->type,
                'total_qty'    => $dtlist->subqty,
                'total_price'  => $dtlist->subprice,
                // 'subtotal_price' => 'Rp ' . number_format($dtlist->subtotal_price, 0)
            ];
        endforeach;

        $response = array(
            'data' => $data,
        );

        return json_encode($response);
    }

    public function earningsOverview()
    {
        $findDataList = null;
        $data = [];

        $findDataList = DB::table('transactions')
            ->select(
                DB::raw('count(transaction_id) as count_data'),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month,SUM(total_price) as total_earning')
            )
            ->groupBy('year', 'month')
            ->get();

        foreach ($findDataList as $dtlist) :
            $getMonth   = $dtlist->month;
            $intEarning = (int)$dtlist->total_earning;
            $dateObj    = DateTime::createFromFormat('!m', $getMonth);
            $monthName  = $dateObj->format('M');
            $data[] = [
                'month_db'      => $monthName,
                'count_data'    =>  $dtlist->count_data,
                'total_earning' => $intEarning,
                'total_earning_rp' => 'Rp ' . number_format($dtlist->total_earning, 0)
            ];
        endforeach;

        $response = array(
            'data' => $data,
        );

        return json_encode($response);
    }
}
