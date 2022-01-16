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
            ->select(DB::raw('prd.product_id as prod_id,prd.name'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty, 
                            SUM(tr.subtotal_price) as subprice'))
            ->join('products as prd', 'tr.product_id', '=', 'prd.product_id')
            ->groupBy('prd.product_id')
            ->groupBy('prd.name')
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
                'product_id' => $dtlist->prod_id,
                'product_name' => $dtlist->name,
                'total_qty' => $dtlist->subqty,
                'total_price' => $dtlist->subprice,
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
                'month_db' => $monthName,
                'count_data' =>  $dtlist->count_data,
                'total_earning' => $intEarning,
                'total_earning_rp' => 'Rp ' . number_format($dtlist->total_earning, 0)
            ];
        endforeach;

        $response = array(
            'data' => $data,
        );

        return json_encode($response);
    }

    // public function earningsOverview()
    // {
    //     $findDataList = null;
    //     $data_month = [];
    //     $data = [];

    //     $findDataList = DB::table('transactions')
    //         ->select(
    //             DB::raw('count(transaction_id) as count_data'),
    //             DB::raw('YEAR(created_at) year, MONTH(created_at) month,SUM(total_price) as total_earning')
    //         )
    //         ->groupBy('year', 'month')
    //         ->get();

    //     // $months = array("1" => "Jan", "2" => "Feb", "3" => "Mar", "4" => "Apr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Aug", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");
    //     $months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");


    //     foreach ($findDataList as $dtlist) :
    //         $getMonth  = $dtlist->month;
    //         $dateObj   = DateTime::createFromFormat('!m', $getMonth);
    //         $monthName = $dateObj->format('M');
    //         $dataDb[]  = $getMonth;
    //     endforeach;

    //     foreach ($months as $key => $month) :
    //         if (in_array($key, $dataDb)) :
    //             $getEearn  = $dtlist->total_earning;
    //             $countData = 333;
    //         else :
    //             $getEearn  = 0;
    //             $countData = 0;
    //         endif;
    //         $data[] = [
    //             'month_db' => $key,
    //             'count_data' => $countData,
    //             'total_earning' => $getEearn,
    //             // 'total_earning_rp' => 'Rp ' . number_format($dtlist->total_earning, 0)
    //         ];
    //     endforeach;

    //     $response = array(
    //         'data' => $data,
    //         // 'datatest' => $dataDb,
    //         // 'data_month' => $data_month,
    //     );

    //     return json_encode($response);
    // }
}
