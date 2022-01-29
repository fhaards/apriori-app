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

        $xto = 0;
        foreach ($request->comb as $keys => $valcomb) {
            $xto++;
            $setCombine[] = [$valcomb];
        }

        $data['combineResults'] = $setCombine;
        $data['getArray']    = APHELP::getAprioriTable($getArray);
        $data['transact']    = TRS::orderBy('created_at', 'DESC')->get();
        $data['prod']        = $prodlist->get();
        $data['headerpages'] = $this->pagesname;
        $data['user']        = Auth::user();
        return view('apriori.apriori_table', $data);
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
