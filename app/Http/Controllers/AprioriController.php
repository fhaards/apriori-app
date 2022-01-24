<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products as PRD;
use App\Models\Transaction as TRS;
use App\Models\transactions_list as TRSLIST;
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
        //
    }

    public function show($id)
    {
        // $translist =  DB::table('transactions_lists as tr')
        //             ->select(DB::raw('prd.id as prod_id,prd.name,prd.type'))
        //             ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
        //             ->join('products as prd', 'tr.product_id', '=', 'prd.id')
        //             ->groupBy('prd.id')
        //             ->groupBy('prd.name')
        //             ->groupBy('prd.type');

        $datalist = [];
        $prodlist = DB::table('products as prd')
            ->join('transactions_lists as tr', 'prd.id', '=', 'tr.product_id')
            ->select(DB::raw('prd.id as prod_id,prd.name,prd.type'))
            ->groupBy('prd.id', 'prd.name', 'prd.type');


        $trans = TRS::get();
        foreach ($trans as $tr) {
            $idtrans = $tr->transaction_id;
            $translist = DB::table('transactions_lists as tr')
                ->select(DB::raw('tr.product_id,tr.subtotal_qty'))
                ->where('tr.transaction_id', '=', $idtrans)
                ->groupBy('tr.product_id')
                ->groupBy('tr.subtotal_qty')->get();
            foreach ($translist as $val) {
                $dataList[] = array(
                    'subqty' => $val->subtotal_qty
                );
            }
        }

        $data['trans']       = TRS::get();
        $data['translist']   = $dataList;
        $data['prodlist']    = $prodlist->get();
        $data['user']        = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('apriori.apriori_table', $data);
    }

    public function combineTest()
    {
        $prodlist2 = DB::table('products as prd')
            ->join('transactions_lists as tr', 'prd.id', '=', 'tr.product_id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')->get();
        echo '===================';
        foreach ($prodlist2 as $item) {
            $iditem = $item->type;
            echo $iditem . " | ";
        }
        echo "<br>";
        $trans = TRS::get();
        foreach ($trans as $tr) {
            $idtrans = $tr->transaction_id;
            echo $tr->transaction_id . ' = ';

            $translist =  DB::table('transactions_lists as tr')
                ->select(DB::raw('tr.product_id,tr.subtotal_qty'))
                ->where('tr.transaction_id', '=', $idtrans)
                // ->groupBy('tr.product_id')
                // ->groupBy('tr.subtotal_qty')
                ->get();
            foreach ($translist as $val) {
                $subtQty = $val->subtotal_qty;
                echo $subtQty . " / ";
            }
            echo "<br>";
        }


        exit;
    }

    public function combineTest2()
    {
        $data = [];
        $prodlist2 = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->groupBy('prd.id', 'prd.name', 'prd.type');
        echo 'PRODUCT NAME ================ ';
        $eachProd = $prodlist2->get();
        foreach ($eachProd as $item) {
            $typePrd = $item->type;
            $idPrd   = $item->id;
            echo $idPrd . " | ";
        }


        echo "<br>";
        $trans     = DB::table('transactions as tr')
            ->orderBy('created_at', 'ASC')
            ->get();
        $eachProd2 = PRD::get();
        foreach ($trans as $item2) {
            $idPrd2 = $item2->transaction_id;
            echo $idPrd2 . " &nbsp ";
            $translist =  DB::table('transactions_lists as tr')
                ->where('tr.transaction_id', '=', $idPrd2)
                ->get();
            foreach ($translist as $val) {
                $subtQty = $val->subtotal_qty;
                echo $subtQty;
            }
            echo "<br>";
        }

        echo "<br>";


        exit;
    }

    public function combineTest3()
    {
        $data = [];
        $prodlist2 = PRD::query();
        $eachProd  = $prodlist2->orderBy('name', 'ASC')->get();
        foreach ($eachProd as $item) {
            echo $item->type . ' - ';
        }

        echo "<br>";
        $trans = TRS::orderBy('created_at', 'DESC')->get();
        $eachProd2  = $prodlist2->orderBy('name', 'ASC')->get();
        foreach ($trans as $tr) {
            $idtrans = $tr->transaction_id;
            $translist =  DB::table('transactions_lists as tr')
                // ->select(DB::raw('tr.product_id,tr.subtotal_qty,(CASE WHEN tr.product_id IS NOT NULL THEN 1 ELSE 0 END) AS getQty'))
                ->select(DB::raw("tr.product_id,tr.subtotal_qty,tr.transaction_id"))
                ->where('tr.transaction_id', '=', $idtrans)
                ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                ->get();

            foreach ($eachProd2 as $item) {
                foreach ($translist as $val) {
                    $transProdId = $val->product_id;
                    if ($transProdId == $item->id) {
                        echo $val->subtotal_qty;
                    } else {
                        echo "0";
                    }
                    echo "|";
                }
            }
            echo "<br>";
        }
        exit;
    }

    public function combineTest4()
    {
        $data    = [];
        $results = 0;
        $prodlist2 = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');
        $eachProd  = $prodlist2->get();
        foreach ($eachProd as $item) {
            echo $item->type . ' - ';
        }


        echo "<br>";
        $trans = TRS::orderBy('created_at', 'DESC')->get();
        $eachProd2  = $prodlist2->get();
        foreach ($trans as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                echo "(ProdId  " . $prodId . ")";
                $translist = DB::table('transactions_lists as tr')
                    ->select(DB::raw("tr.product_id,tr.subtotal_qty,tr.transaction_id"))
                    ->where('tr.transaction_id', '=', $idtrans)
                    // ->where('tr.product_id', '=', $prodId)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    if ($prodIdTrans == $prodId) {
                        $results = $qty;
                    }
                }
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $prodIdTrans . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |';
            }
            echo '<br>' . $tr->transaction_id . "<br>";
        }
        exit;
    }

    public function combineTest5()
    {
        $data    = [];
        $results = 0;
        $prodlist2 = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');
        $eachProd  = $prodlist2->get();
        $coutProd  = $eachProd->count();
        foreach ($eachProd as $item) {
            echo $item->type . ' - ';
        }


        echo "<br>";

        $trans = TRS::orderBy('created_at', 'DESC')->get();

        $eachProd2  = $prodlist2->get();
        foreach ($trans as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                // echo "(ProdId  " . $prodId . ")";
                $translist = DB::table('transactions_lists as tr')
                    ->select(DB::raw("tr.product_id,tr.subtotal_qty,tr.transaction_id"))
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    if ($prodIdTrans == $prodId) {
                        $results = $qty;
                    } else {
                        $results = 0;
                    }
                }
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $results . '  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |';
            }
            echo '' . $tr->transaction_id . "<br>";
        }
        exit;
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
