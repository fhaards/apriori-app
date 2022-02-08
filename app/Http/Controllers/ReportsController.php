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
        $findDatad = TRS::whereDate("created_at",'=',$reqDate);
        // ABORT IS DATA WAS EMPTY
        if (empty($findDatad->count())) :
            return abort(404);
        endif;


        $getData['data']  = TRANSHELP::getTransByDateFull($reqDate);
        $getData['title'] = $this->printName;
        $pdf = PDF::loadview('reports.r-t-day.r_trans_day', $getData);
        return $pdf->stream($this->printName . "- Day" . ".pdf");
    }
}
