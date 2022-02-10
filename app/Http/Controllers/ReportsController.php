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
use App\Http\Helpers\TransactionsHelpers as TRANSHELP;
use PDF;

class ReportsController extends Controller
{
    private $pagesname;
    public function __construct()
    {
        $this->printName = 'Report Transaction';
        $this->pagesname = 'Reports';
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('reports.reports_table', $data);
    }

    public function reportsTransDay(Request $request, $reqDate)
    {
        //GET REQUEST DATE
        $findDatad = TRS::whereDate("created_at", '=', $reqDate);

        // ABORT IS DATA WAS EMPTY
        if (empty($findDatad->count())) :
            return abort(404);
        endif;

        $findTransaction = DB::table('transactions')
            ->selectRaw('SUM(total_price) as totprice,SUM(total_qty) as totqty')
            ->whereDate('created_at', "=", $reqDate);


        $getData['date']  = $reqDate;
        $getData['transact'] = $findTransaction->first();
        $getData['data']  = TRANSHELP::getTransByDateFull($reqDate);
        $getData['title'] = $this->printName;
        $pdf = PDF::loadview('reports.reports_by_day', $getData);
        return $pdf->stream($this->printName . "- Day" . ".pdf");
    }

    public function reportsTransMonth(Request $request, $reqDate)
    {
        //GET REQUEST DATE
        $findData = TRS::whereMonth("created_at", '=', $reqDate);

        $findTransaction = DB::table('transactions')
            ->selectRaw('SUM(total_price) as totprice,SUM(total_qty) as totqty')
            ->whereMonth('created_at', "=", $reqDate);

        if (empty($findData->count())) :
            return abort(404);
        endif;

        $getData['date']  = date('F', mktime(0, 0, 0, $reqDate, 10));
        $getData['transact'] = $findTransaction->first();
        $getData['data']  = $findData->get();
        $getData['title'] = $this->printName;
        $pdf = PDF::loadview('reports.reports_by_month', $getData);
        return $pdf->stream($this->printName . "- Day" . ".pdf");
    }

    public function reportsTransYear(Request $request, $reqDate)
    {
        //GET REQUEST DATE
        $findData = TRS::whereYear("created_at", '=', $reqDate);

        $findTransaction = DB::table('transactions')
            ->selectRaw('SUM(total_price) as totprice,SUM(total_qty) as totqty')
            ->whereMonth('created_at', "=", $reqDate);

        if (empty($findData->count())) :
            return abort(404);
        endif;

        $getData['date']  = $reqDate;
        $getData['transact'] = $findTransaction->first();
        $getData['data']  = $findData->get();
        $getData['title'] = $this->printName;
        $pdf = PDF::loadview('reports.reports_by_year', $getData);
        return $pdf->stream($this->printName . "- Day" . ".pdf");
    }
}
