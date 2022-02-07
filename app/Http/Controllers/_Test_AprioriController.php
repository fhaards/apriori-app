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


class _Test_AprioriController extends Controller
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

    public function comb1proccessJson(Request $request)
    {
        $data = [];
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;


        $draw = $request->input('draw');
        $dateFilter = $request->get('date');
        $limit =  ($request->get('limit') ? $request->get('limit')  : 100);

        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;

        $findData =  DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->selectRaw('count(product_id) as count')
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('product_id', 'name')
            ->orderBy('subqty', 'DESC')
            ->paginate($limit);

        if ($findData->total() > 0) {
            foreach ($findData as $prd) {
                $countPrd = (float)$prd->count;
                $gsupport = $countPrd / $sumAlltransF;
                $gconfide = $countPrd / $countPrd;
                $data[] = [
                    'name'    => $prd->name,
                    'support' => "Support = " . $countPrd . " / " . $sumAlltransF . " = " . $gsupport,
                    'confidence' => "Confidence = " . $countPrd . " / " . $countPrd . " = " . $gconfide,
                ];
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

    public function comb1rulesJson(Request $request)
    {
        $data = [];
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;
        $tsup  = "";
        $tconf = "";
        // $tss1 = floatval($ts1);


        $draw = $request->input('draw');
        $dateFilter = $request->get('date');
        $limit =  ($request->get('limit') ? $request->get('limit')  : 100);

        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;

        $findData =  DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select('product_id', 'name')
            ->selectRaw('count(product_id) as count')
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('product_id', 'name')
            ->orderBy('subqty', 'DESC')
            ->paginate($limit);

        if ($findData->total() > 0) {
            foreach ($findData as $prd) {
                $prodname = $prd->name;
                $countPrd = (float)$prd->count;
                $gsupport = (float)$countPrd / $sumAlltransF;
                $gconfide = (float)$countPrd / $countPrd;
                $supxconf = (float)$gsupport * $gconfide;

                // if ($gsupport > $tss1) :
                //     $tsup = "YES";
                // else :
                //     $tsup = "NO";
                // endif;

                // if ($gconfide > $tss1) :
                //     $tconf = "YES";
                // else :
                //     $tconf = "NO";
                // endif;

                $data[] = [
                    'rules'      => "If buy " . $prodname . " Then buy" . $prodname,
                    'support'    => $gsupport,
                    'confidence' => $gconfide,
                    'supxconf'   => $gsupport,
                    'tsup'       => $tsup,
                    'tconf'      => $tconf,
                ];
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

    public function testCombProcess(Request $request)
    {
        $data = [];
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;

        $sumAllTrans = APHELP::sumAllTransaction();
        $sumAlltransF = (float)$sumAllTrans;

        $prodlist = APHELP::getProductCount();
        foreach ($prodlist as $prd) {
            $countPrd = (float)$prd->count;
            $gsupport = $countPrd / $sumAlltransF;
            $gconfide = $countPrd / $countPrd;
            $data[] = [
                'support' => $gsupport,
                'confide' => $gconfide,
            ];
        }
        echo json_encode($data);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $getArray = [];
        //load product lists
        $prodlist = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        // $results = 0;
        // $transact     = TRS::orderBy('created_at', 'DESC')->get();
        // $prod         = $prodlist->get();
        // $dataList     = APHELP::getAprioriTable($getArray);

        $data['getArray']    = APHELP::getAprioriTable($getArray);
        $data['transact']    = TRS::orderBy('created_at', 'DESC')->get();
        $data['prod']        = $prodlist->get();
        $data['headerpages'] = $this->pagesname;
        $data['user']        = Auth::user();
        return view('apriori.apriori_table', $data);
        // $data = array(
        //     'user' => $user,
        //     'headerpages' => $headerpages,
        //     'prod' => $prod,
        //     'transact'  => $transact,
        //     'getArray' => $dataList
        // );

        // return view('apriori.apriori_table', compact('data'));

    }

    public function combineTest()
    {
        $data    = [];

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
        echo "----------------------------------------------------------";
        echo "<br>";

        // echo "(ProdId  " . $prodId . ")";

        $results = 0;
        $arrPrd  = [];
        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist2->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $translist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }
                echo '&nbsp;' . $results     . '  &nbsp; |';
            }
            echo '' . $tr->transaction_id . "<br>";
        }
        exit;
    }

    public function combineTest2()
    {
        $datalist = [];
        //load product lists
        $prodlist = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        $results = 0;
        $arrPrd  = [];
        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $translist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }
                $datalist[] = ['qty' => $results];
            }
        }

        // $data['transactList'] = $datalist;
        // $data['transact']     = TRS::orderBy('created_at', 'DESC')->get();
        // $data['prod']         = $prodlist->get();
        // $data['prodToTrans']  = $prodlist->get();

        $user         = Auth::user();
        $headerpages  = $this->pagesname;
        $data = array(
            'user' => $user,
            'headerpages' => $headerpages,
            'datalist' => $datalist
        );

        echo json_encode($data);
    }

    public function combineTest3()
    {
        $sendToDatalist = [];

        //load product lists
        $prodlist = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');

        $results = 0;
        $arrPrd  = [];
        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $tbtranslist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty');

                $datalist = $tbtranslist->get();
                foreach ($datalist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }
                $sendToDatalist[] = $results;
            }
        }

        $transact   = TRS::orderBy('created_at', 'DESC')->get();
        $prod       = $prodlist->get();


        $user         = Auth::user();
        $headerpages  = $this->pagesname;
        $data = array(
            'user' => $user,
            'headerpages' => $headerpages,
            'prod' => $prod,
            'transact'  => $transact,
            'datalist'  => $sendToDatalist,
            // 'arrPrd' => $arrPrd
        );
        echo json_encode($data);
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
        echo "----------------------------------------------------------";
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

    public function combineTest6()
    {
        $data    = [];
        $results = 0;
        $arrPrd  = [];
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
        echo "----------------------------------------------------------";
        echo "<br>";

        // echo "(ProdId  " . $prodId . ")";


        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist2->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $translist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }
                echo '&nbsp;' . $results     . '  &nbsp; |';
            }
            echo '' . $tr->transaction_id . "<br>";
        }
        exit;
    }

    public function combineTest7()
    {
        $data       = [];
        $results    = 0;
        $arrPrd     = [];
        $trId       = [];
        $arrTrans   = [];
        $qty        = [];
        $prodIdTrans = [];

        $prodlist2  = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');
        $eachProd  = $prodlist2->get();
        $coutProd  = $eachProd->count();
        echo "TRANSACTIONS NUMB  --------- ";
        foreach ($eachProd as $item) {
            echo $item->type . ' - ';
        }

        echo "<br>";
        echo "-----------------------------------------------------------------------------------------------";
        echo "<br>";

        // echo "(ProdId  " . $prodId . ")";


        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist2->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $tbtranslist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')->get();

                foreach ($tbtranslist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrTrans[]  = [
                        'thisId' => [$prodIdTrans],
                        'toqty'  => $qty,
                    ];
                    echo json_encode($arrTrans);
                }
            }
        }

        foreach ($transactions as $tr2) {
            foreach ($eachProd2 as $item2) {
                $prodId2  = $item2->id;
                foreach ($arrTrans as $value) {
                    // echo $value['qty'][0];
                    $arrId   = array($value['thisId']);
                    $qtys    = $value['toqty'];
                }
                if (in_array($prodId2, $arrId)) {
                    $results = $qtys;
                } else {
                    $results = 0;
                }
                echo '&nbsp;' .  $results  . '  &nbsp; |';
            }
            echo "<br>";
        }
        exit;
    }

    public function combineTest8()
    {
        $data       = [];
        $results    = 0;
        $arrPrd     = [];
        $trId       = [];
        $arrTrans   = [];
        $qty        = [];
        $prodIdTrans = [];

        $prodlist2  = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');
        $eachProd  = $prodlist2->get();
        $coutProd  = $eachProd->count();
        echo "TRANSACTIONS NUMB  --------- ";
        foreach ($eachProd as $item) {
            echo $item->type . ' - ';
        }

        echo "<br>";
        echo "-----------------------------------------------------------------------------------------------";
        echo "<br>";

        // echo "(ProdId  " . $prodId . ")";


        $transactions  = TRS::orderBy('created_at', 'DESC')->get();
        $transactions2 = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist2->get();
        $eachProd3  = $prodlist2->get();

        // foreach ($transactions as $tr) {
        //     $idtrans = $tr->transaction_id;
        //     foreach ($eachProd2 as $item) {
        //         $prodId    = $item->id;
        //         $tbtranslist = DB::table('transactions_lists as tr')
        //             ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
        //             ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
        //             ->where('tr.product_id', '=', $prodId)
        //             ->where('tr.transaction_id', '=', $idtrans)
        //             ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
        //             ->get();
        //     }
        // }

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $item) {
                $prodId    = $item->id;
                $ceks = DB::table('transactions_lists as tr')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($ceks as $keys => $value) {
                    echo $value->subtotal_qty;
                }
            }


            echo "<br>";
        }
    }

    public function combineTest9()
    {
        $getArray = [];
        $qty      = [];
        $subqty   = [];
        $arrPrd   = [];
        $result   = [];
        $idTransLoop = [];
        $idProducts  = [];
        $productsId  = [];
        $LoopProducts = [];
        $type = [];
        $getVal = [];

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
            $idtrans       = $tr->transaction_id;
            echo $idtrans . '<<br>';
            foreach ($loopProduct as $item) {

                $prodId = $item->id;
                // $trans  = DB::table('transactions_lists as tr')
                //     ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                //     ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                //     ->where('tr.product_id', '=', $prodId)
                //     ->where('tr.transaction_id', '=', $idtrans)
                //     ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty');

                $trans = DB::table('transactions_lists as tr')
                    ->select('subtotal_qty as subqty')
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->get();

                foreach ($trans as $val) {
                    // $prodIdTrans = $val->product_id;
                    $qty[] = $val->subqty;
                    // $arrPrd      = array($prodIdTrans);
                }
                // $qty[] = $transList->subtotal_qty;

            }


            // if (in_array($prodId, $arrPrd)) {
            //     $getVal = $qty;
            // } else {
            //     $getVal = 0;
            // }
            $getArray[] = [
                $qty
            ];
        }






        // $getArray = array_merge($LoopTransaction, $LoopProducts);
        // $getArray[] = [
        //     $idTransLoop => [
        //         'prodId' => [$idProducts],
        //         'qty' => [$subqty],
        //         'results' => $results
        //     ],
        // ];



        // $getArray = [
        //     'transaction_id' => $idTransLoop,
        //     'sub_qty' => [
        //         $LoopProducts
        //     ],
        // ];



        // $LoopTransaction = [
        //     'transaction_id' => $idTransLoop,
        // ];

        // $getArray = array_merge($LoopTransaction, $LoopProducts);
        echo json_encode($getArray);
    }

    public function combineTest10()
    {
        $getArray = [];
        $qty      = [];
        $countProduct = 0;
        $arrPrd  = [];
        $results = [];
        $groups  = [];

        $listProduct = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');


        $listTransact2 = TRS::get();
        $loopProduct   = $listProduct->get();
        $loopProduct2  = $listProduct->get();
        // $countProduct  = $loopProduct->count();
        // $splice        = ((int)$countProduct - 1);

        $countProduct = $loopProduct->count();
        $cTrans       = $listTransact2->count();

        $listTransact  = TRS::get();

        foreach ($listTransact as $key => $tr) {
            foreach ($loopProduct as $item) {
                $prodId = $item->id;
                $arrPrd = array($prodId);
                $trans  = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $item->id)
                    ->where('tr.transaction_id', '=', $tr->transaction_id)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get();

                foreach ($trans as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    // $arrPrd      = array($prodIdTrans);
                }

                if (in_array($prodIdTrans, $arrPrd)) {
                    $results[] = $qty;
                } else {
                    $results[] = 0;
                }

                $collection = collect($results);

                $groups = $collection->split($cTrans);
                $torest = $groups->all();
            }
        }


        foreach ($listTransact2 as $key => $tr) {
            $idtrans = $tr->transaction_id;
            $getArray[] = [
                'counts' => $countProduct,
                'trans_id' => $idtrans,
                'sub_qty' => $torest
            ];
        }



        echo json_encode($getArray);

        // TRSLIST::select('subtotal_qty')
        // ->where('transaction_id', $tr->transaction_id)
        // ->where('product_id', $item->id)
        // ->groupBy('subtotal_qty', 'transaction_id')
        // ->get();
        // $collection = collect($trans);
        // $groups = $collection->splitIn($countProduct);
        // $groups->all();
    }

    public function combineTest11()
    {
        $data       = [];
        $results    = [];
        $arrPrd     = [];
        $getArray   = [];
        $prodlist2  = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->select(DB::raw('prd.id,prd.name,prd.type'))
            ->addSelect(DB::raw('SUM(tr.subtotal_qty) as subqty'))
            ->groupBy('prd.id', 'prd.name', 'prd.type')
            ->orderBy('subqty', 'DESC');
        $eachProd  = $prodlist2->get();

        $transactions = TRS::orderBy('created_at', 'DESC')->get();
        $transCount = $transactions->count();
        $eachProd2  = $prodlist2->get();

        foreach ($transactions as $tr) {
            $idtrans = $tr->transaction_id;
            foreach ($eachProd2 as $key => $item) {
                $prodId    = $item->id;
                $translist = DB::table('transactions_lists as tr')
                    ->leftJoin('transactions as trans', 'tr.transaction_id', '=', 'trans.transaction_id')
                    ->select(DB::raw("tr.product_id,tr.transaction_id,tr.subtotal_qty"))
                    ->where('tr.product_id', '=', $prodId)
                    ->where('tr.transaction_id', '=', $idtrans)
                    ->groupBy('tr.product_id', 'tr.transaction_id', 'tr.subtotal_qty')
                    ->get()->toArray();

                foreach ($translist as $val) {
                    $prodIdTrans = $val->product_id;
                    $qty         = $val->subtotal_qty;
                    $arrPrd      = array($prodIdTrans);
                }
                if (in_array($prodId, $arrPrd)) {
                    $results = $qty;
                } else {
                    $results = 0;
                }

                $getArray[] = $results;
                return json_encode($getArray);
            }
        }
    }

    public function combineTest12()
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
                'trans_id' => $idtrans,
                'sub_qty' => $groups[$key]
            ];
        }
        echo json_encode($getArray);
        // return $getArray;
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
