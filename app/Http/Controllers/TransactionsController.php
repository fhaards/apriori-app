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
use PDF;

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

        // FILTERED
        // $fillMonth    = $request->get('month');
        $getFilterFrom = $request->get('filRangeFrom');
        $filRangeFrom  = date('Y-m-d', $getFilterFrom);
        $filRangeTo    = date('2022-01-20');

        // DRAW TABLE
        $draw       = $request->input('draw');
        $limit      = ($request->get('limit') ? $request->get('limit')  : 100);
        // $dateFilter = $request->get('date');

        // GET DATA FROM DATABASE
        // $findData = $findData->whereMonth('created_at','=', $fillMonth);
        $findData = TRS::query();
        if (!is_null($getFilterFrom)) {
            $findData = $findData->whereBetween('created_at', [$filRangeFrom, $filRangeTo]);
        }
        $findData = $findData->paginate($limit);
        if ($findData->total() > 0) {
            foreach ($findData as $dt) :
                $data[] = [
                    'transaction_id'  => $dt->transaction_id,
                    'customer_name'   => $dt->customer_name,
                    'created'         => date('d/m/Y', strtotime($dt->created_at)),
                    'created_at_full' => date('d/m/Y H:i:s', strtotime($dt->created_at)),
                    'created_str'     => Carbon::parse($dt->created_at)->isoFormat('dddd, DD - MMMM - Y'),
                    'total_qty'       => $dt->total_qty,
                    'total_price'     => 'Rp. ' . number_format($dt->total_price, 2)
                    // 'created'      => Carbon::parse($dt->created_at)->isoFormat('dddd, D MMMM Y (H : mm)'),
                    // 'created_str'  => date('d/m/Y', strtotime($dt->created_at)),
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
        $transID       = 'TR-' . GLBHelp::getRandId();
        $transCustName = $request->input('customer_name');
        $productNumber = $request->input('product_number');

        if (!$error) {
            for ($i = 0; $i < $productNumber; $i++) {
                $productId   = $request->input("product_id_$i");
                $productQty  = $request->input("qty_product_$i");
                $setQty      = (int)$productQty;
                $countQty    += $setQty;

                $getPrice    = PRD::find($productId);
                $getPrice    = $getPrice->price;
                $getSubTotal = $setQty * $getPrice;

                //for transaction main table
                $totalPrice += $getSubTotal;

                $inputTranslist = new TRSLIST;
                $inputTranslist->transaction_id = $transID;
                $inputTranslist->product_id     = $productId;
                $inputTranslist->subtotal_qty   = $productQty;
                $inputTranslist->subtotal_price = $getSubTotal;
                $inputTranslist->save();

                $getProducts = PRD::where('id', $productId)->first();
                $getQtyPrd   = $getProducts->stock;
                $minQtyPrd   = $getQtyPrd - $setQty;
                if ($getProducts == true) {
                    $getProducts->stock = (int)$minQtyPrd;
                    $getProducts->save();
                }
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

    public function storeBackups(Request $request)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];
        $countQty = 0;
        $totalPrice = 0;

        //CREATE PRODUCT ID
        $transID       = 'TR-' . GLBHelp::getRandId();
        $transCustName = $request->input('customer_name');
        $productNumber = $request->input('product_number');

        if (!$error) {
            for ($i = 0; $i < $productNumber; $i++) {
                $productId   = $request->input("product_id_$i");
                $productQty  = $request->input("qty_product_$i");
                $setQty      = (int)$productQty;
                $countQty    += $setQty;

                $getPrice    = PRD::find($productId);
                $getPrice    = $getPrice->price;
                $getSubTotal = $setQty * $getPrice;

                //for transaction main table
                $totalPrice += $getSubTotal;

                $inputTranslist = new TRSLIST;
                $inputTranslist->transaction_id = $transID;
                $inputTranslist->product_id     = $productId;
                $inputTranslist->subtotal_qty   = $productQty;
                $inputTranslist->subtotal_price = $getSubTotal;
                $inputTranslist->save();
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
        $findData = null;
        $totalList = 0;
        $data = [];
        $data2 = [];

        $findData     = TRS::where('transaction_id', $id)->get();
        $findDataList = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->where('tr.transaction_id', '=', $id)
            ->get();
        $totalList   = TRSLIST::where('transaction_id', $id)->count();

        foreach ($findData as $dt) :
            $data[] = [
                'transaction_id' => $dt->transaction_id,
                'customer_name' => $dt->customer_name,
                'total_qty' => $dt->total_qty,
                'total_price' => 'Rp ' . number_format($dt->total_price, 0),
                'created' => Carbon::parse($dt->created_at)->isoFormat('dddd, D MMMM Y'),
            ];
        endforeach;

        foreach ($findDataList as $dtlist) :
            $data2[] = [
                'product_id' => $dtlist->product_id,
                'product_name' => $dtlist->name,
                'product_type' => $dtlist->type,
                'product_price' => 'Rp ' . number_format($dtlist->price, 0),
                'subtotal_qty' => $dtlist->subtotal_qty,
                'subtotal_price' => 'Rp ' . number_format($dtlist->subtotal_price, 0)
            ];
        endforeach;

        $response = array(
            'data' => $data,
            'list' => $data2,
            'list_total' => $totalList
        );

        return json_encode($response);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function printInvoice(Request $request, $id)
    {
        $findData = null;
        $findDataList = DB::table('transactions_lists as tr')
            ->join('products as prd', 'tr.product_id', '=', 'prd.id')
            ->where('tr.transaction_id', '=', $id);

        $data = [];
        $data['user'] = Auth::user();
        $data['headerpages'] = 'INVOICE-DOCUMENT';
        $data['transaction'] = TRS::where('transaction_id', $id)->first();
        $data['transaction_list'] = $findDataList->get();
        $pdf = PDF::loadview('transactions.transactions_print', $data);
        return $pdf->stream('Invoice-' . $id . '.pdf');
    }

    public function destroy($id)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];
        $defId = $id;

        $transactions = TRS::find($defId);
        $deleteTrans  = $transactions->delete();
        if ($deleteTrans) {
            $list = TRSLIST::where('transaction_id', $defId)->delete();
            if ($list) {
                $error = false;
                $status = 200;
                $message = 'Delete Success';
            } else {
                $error = false;
                $status = 210;
                $message = 'Ops, Something wrong';
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
}
