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

class TransactionsController extends Controller
{
    private $pagesname;
    public function __construct()
    {
        $this->pagesname = 'Transactions';
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('transactions.transactions_table', $data);
    }

    public function showAll(Request $request)
    {
        $totalData = 0;
        $totalDataFiltered = 0;
        $findData = null;
        $data = [];


        // DRAW TABLE
        $draw       = $request->input('draw');
        $dateFilter = $request->get('date');
        $limit      = ($request->get('limit') ? $request->get('limit')  : 100);

        // GET DATA FROM DATABASE
        $findData = TRS::latest()->paginate($limit);
        if ($findData->total() > 0) {
            foreach ($findData as $dt) :
                $data[] = [
                    'transaction_id' => $dt->transaction_id,
                    'customer_name' => $dt->customer_name,
                    // 'created'        => Carbon::parse($dt->created_at)->isoFormat('dddd, D MMMM Y (H : mm)'),
                    'created'        => Carbon::parse($dt->created_at)->isoFormat('dddd, D MMMM Y'),
                    'total_qty'      => $dt->total_qty,
                    'total_price'    => 'Rp. ' . number_format($dt->total_price, 2)
                ];
            endforeach;

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

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];
        $countQty = 0;
        $totalPrice = 0;

        //CREATE PRODUCT ID
        $transID = GLBHelp::getRandId();
        $transCustName = $request->input('customer_name');
        $productNumber = $request->input('product_number');

        if (!$error) {
            for ($i = 0; $i < $productNumber; $i++) {
                $productId  = $request->input("product_id_$i");
                $productQty = $request->input("qty_product_$i");
                $setQty   = (int)$productQty;
                $countQty += $setQty;

                $getPrice = PRD::find($productId);
                $getPrice = $getPrice->price;
                $getSubTotal  = $countQty * $getPrice;

                $inputTranslist = new TRSLIST;
                $inputTranslist->transaction_id = $transID;
                $inputTranslist->product_id     = $productId;
                $inputTranslist->subtotal_qty   = $productQty;
                $inputTranslist->subtotal_price = $getSubTotal;
                $inputTranslist->save();

                //for transaction main table
                $totalPrice += $getSubTotal;
            }

            $inputTrans = new TRS;
            $inputTrans->transaction_id = $transID;
            $inputTrans->customer_name  = $transCustName;
            $inputTrans->total_qty      = $countQty;
            $inputTrans->total_price    = $totalPrice;
            $insert = $inputTrans->save();
            if ($insert) {
                $error = false;
                $status = 200;
                $message = 'Input Data Success';
            } else {
                $error = false;
                $status = 210;
                $message = 'Ops, Something Wrong when Input Data';
            }
        }

        $resp = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $error,
        ];

        return response()->json($resp, 200);
    }


    public function show($id)
    {
        //
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
