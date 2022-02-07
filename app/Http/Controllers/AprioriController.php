<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products as PRD;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;
use App\Http\Helpers\AprioriHelpers as APHELP;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AprioriController extends Controller
{
    private $pagesname;
    public function __construct()
    {
        $this->pagesname = 'Apriori Analysis';
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('apriori.apriori_form', $data);
        // $data['productsTable'] = Products::all();
        // return view('products.products_table', $data);
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        $getArray = [];
        $prodlist = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        $data['getArray']    = APHELP::getAprioriTable($getArray);
        $data['transact']    = TRS::orderBy('created_at', 'DESC')->get();
        $data['prod']        = $prodlist->get();
        $data['headerpages'] = $this->pagesname;
        $data['user']        = Auth::user();
        return view('apriori.apriori_table', $data);
    }

    public function store(Request $request)
    {
        $getArray = [];
        $setCombine = [];

        $prodlist = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        // SlAP THRESHOLD
        $data['ts1'] = $request->ts1;
        $data['tc1'] = $request->tc1;
        $data['ts2'] = $request->ts2;
        $data['tc2'] = $request->tc2;

        // GET TOTAL TRANSACTION
        $data['countTrans'] = (float)APHELP::sumAllTransaction();

        // FOR COMBINE
        $combineFirst = $this->combineFirst()->get();
        $data['combineFirst'] = $combineFirst;

        // MAIN OBJECTS
        $data['getArray']    = APHELP::getAprioriTable($getArray);
        $data['transact']    = TRS::orderBy('created_at', 'DESC')->get();
        $data['prod']        = $prodlist->get();
        $data['headerpages'] = $this->pagesname;
        $data['user']        = Auth::user();
        return view('apriori.apriori_table', $data);
    }

    public function combineFirst()
    {
        $findData = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->selectRaw('count(product_id) as count')
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('product_id', 'name')
            ->orderBy('subqty', 'DESC');
        return $findData;
    }


    public function combineSecondProccess(Request $request)
    {
        $data = [];
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;

        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;


        $draw = $request->input('draw');
        $dateFilter = $request->get('date');
        $limit =  ($request->get('limit') ? $request->get('limit')  : 100);

        $findData = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->groupBy('product_id', 'name')
            ->paginate($limit);

        if ($findData->total() > 0) {
            foreach ($findData as $dt) {
                $prd1 = $dt->product_id;
                $findData2 = DB::table('transactions_lists as tr')
                    ->join('products as prd', 'tr.product_id', '=', 'prd.id')
                    ->select('product_id', 'name')
                    ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
                    ->whereNotIn('product_id', [$dt->product_id])
                    ->groupBy('product_id', 'name')
                    ->get();

                foreach ($findData2 as $dt2) {
                    $prd2 = $dt2->product_id;
                    $findData3 = TRSLIST::whereIn('product_id', [$prd1, $prd2])->groupBy('product_id');
                    $counts = $findData3->count();

                    $findDataConfidence = TRSLIST::whereIn('product_id', [$prd1])->groupBy('product_id');
                    $countsConfidence = $findDataConfidence->count();

                    $gsupport = (float)$counts / $sumAlltransF; // TRANSAKSI A,B DIBAGI TOTAL TRANSAKSI
                    $gconfide = (float)$counts / $countsConfidence; // TRANSAKSI A,B DIBAGI TRANSAKSI A

                    $gsupports = number_format((float)$gsupport, 2, '.', '');
                    $gconfides = number_format((float)$gconfide, 2, '.', '');

                    $data[] = [
                        'name'    => $dt->name . " &nbsp;,&nbsp; " . $dt2->name,
                        'support' => "Support = " . $counts . " / " . $sumAlltransF . " = " . $gsupports,
                        'confidence' => "Confidence = " . $counts . " / " . $countsConfidence . " = " . $gconfides,
                    ];
                }
            }

            $totalData = $findData->total();
            $totalDataFiltered = $limit;
        }

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalDataFiltered,
            'data' => $data
        );

        return json_encode($response);
    }

    public function combineSecondRules(Request $request)
    {
        $data = [];
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;
        $tsup = "";
        $tconf = "";

        $setSup2 = $request->setSup2;
        $setSupxConf2 = $request->setSupxConf2;

        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;


        $draw = $request->input('draw');
        $dateFilter = $request->get('date');
        $limit =  ($request->get('limit') ? $request->get('limit')  : 100);

        $findData = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->groupBy('product_id', 'name')
            ->paginate($limit);

        if ($findData->total() > 0) {
            foreach ($findData as $dt) {
                $prd1 = $dt->product_id;
                $findData2 = DB::table('transactions_lists as tr')
                    ->join('products as prd', 'tr.product_id', '=', 'prd.id')
                    ->select('product_id', 'name')
                    ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
                    ->whereNotIn('product_id', [$dt->product_id])
                    ->groupBy('product_id', 'name')
                    // ->orderBy('subqty', 'DESC')
                    ->get();

                foreach ($findData2 as $dt2) {
                    $prd2 = $dt2->product_id;
                    $findData3 = TRSLIST::whereIn('product_id', [$prd1, $prd2])->groupBy('product_id');
                    $counts = $findData3->count();

                    $findDataConfidence = TRSLIST::whereIn('product_id', [$prd1])->groupBy('product_id');
                    $countsConfidence = $findDataConfidence->count();

                    $gsupport = (float)$counts / $sumAlltransF; // TRANSAKSI A,B DIBAGI TOTAL TRANSAKSI
                    $gconfide = (float)$counts / $countsConfidence; // TRANSAKSI A,B DIBAGI TRANSAKSI A

                    $gsupports = number_format((float)$gsupport, 2, '.', '');
                    $gconfides = number_format((float)$gconfide, 2, '.', '');
                    $supxconf  = $gsupport * $gconfide;
                    $supxconf  = number_format((float)$supxconf, 2, '.', '');

                    if ($gsupport > $setSup2) :
                        $tsup = "YES";
                    else :
                        $tsup = "NO";
                    endif;

                    if ($gconfide > $setSupxConf2) :
                        $tconf = "YES";
                    else :
                        $tconf = "NO";
                    endif;

                    $data[] = [
                        'rules'      => "If buy &nbsp; <i>" . $dt->name . " </i> &nbsp; Then buy &nbsp; <i>" . $dt2->name . "</i>",
                        'support'    => $gsupports,
                        'confidence' => $gconfides,
                        'supxconf'   => $supxconf,
                        'tsup'       => $tsup,
                        'tconf'      => $tconf,
                    ];
                }
            }

            $totalData = $findData->total();
            $totalDataFiltered = $limit;
        }

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalDataFiltered,
            'data' => $data
        );

        return json_encode($response);
    }

    public function testing(Request $request)
    {
        $data = [];
        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;

        $findData = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->groupBy('product_id', 'name')
            ->get();

        foreach ($findData as $dt) {
            $prd1 = $dt->product_id;
            $findData2 = DB::table('transactions_lists as tr')
                ->join('products as prd', 'tr.product_id', '=', 'prd.id')
                ->select('product_id', 'name')
                ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
                ->whereNotIn('product_id', [$dt->product_id])
                ->groupBy('product_id', 'name')
                ->get();

            foreach ($findData2 as $dt2) {
                $prd2 = $dt2->product_id;
                $findData3 = TRSLIST::whereIn('product_id', [$prd1, $prd2])->groupBy('product_id');
                $counts = $findData3->count();

                $findDataConfidence = TRSLIST::whereIn('product_id', [$prd1])->groupBy('product_id');
                $countsConfidence = $findDataConfidence->count();

                $gsupport = (float)$counts / $sumAlltransF; // TRANSAKSI A,B DIBAGI TOTAL TRANSAKSI
                $gconfide = (float)$counts / $countsConfidence; // TRANSAKSI A,B DIBAGI TRANSAKSI A

                $data[] = [
                    'ProductID' => $dt->product_id . "," . $dt2->product_id,
                    'ProductName' => $dt->name . "," . $dt2->name,
                    'Count' =>  $counts,
                    'Support' => number_format((float)$gsupport, 2, '.', ''),
                    'ConfidenceGet' => $countsConfidence,
                    'Confidence' => number_format((float)$gconfide, 2, '.', ''),
                ];
            }
        }

        echo json_encode($data);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
