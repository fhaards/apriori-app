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


    public function testing(Request $request)
    {
        $data = [];
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

                $data[] = [
                    'ProductID' => $dt->product_id . "," . $dt2->product_id,
                    'ProductName' => $dt->name . "," . $dt2->name,
                    'Count' =>  $counts
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
