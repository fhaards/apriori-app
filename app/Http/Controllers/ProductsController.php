<?php

namespace App\Http\Controllers;

use App\Models\Products as PRD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Helpers\GlobalHelpers as GLBH;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    private $pagesname;
    public function __construct()
    {
        $this->pagesname = 'Products';
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('products.products_table', $data);
        // $data['productsTable'] = Products::all();
        // return view('products.products_table', $data);
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
        $findData = PRD::latest()->paginate($limit);
        if ($findData->total() > 0) {
            foreach ($findData as $dt) :
                $data[] = [
                    'id'      => $dt->id,
                    'name'    => $dt->name,
                    'type'    => $dt->type,
                    'price'   => 'Rp. ' . number_format($dt->price, 2),
                    'stock'   => $dt->stock,
                    'created' => date('d/m/Y H:i:s', strtotime($dt->created_at)),
                    'created_str' => Carbon::parse($dt->created_at)->isoFormat('dddd, DD / MM / Y'),
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


        $productName  = $request->input('name');
        $productType  = $request->input('type');

        //CREATE PRODUCT ID
        // $getUnique1 = GLBH::geneName($productName, $productBrand);
        // $getUnique2 = GLBH::geneRandString();
        // $getUnique3 = date('ymdHis');
        // $productId = $getUnique1 . $getUnique2 . $getUnique3;

        if (!$error) {
            $inputProducts = new PRD;
            $inputProducts->name  = $productName;
            $inputProducts->type = $productType;
            $inputProducts->price = $request->input('price');
            $inputProducts->stock = $request->input('stock');
            $insert = $inputProducts->save();
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
        $findData = null;
        $data = [];

        // GET DATA FROM DATABASE
        $findData = PRD::where('id', $id)->get();
        foreach ($findData as $dt) :
            $data[] = [
                'id'    => $dt->id,
                'name'  => $dt->name,
                'type'  => $dt->type,
                'price' => $dt->price,
                'stock' => $dt->stock,
                'created' => date('d/m/Y - H:i', strtotime($dt->created_at))
            ];
        endforeach;

        $response = array(
            'data' => $data
        );

        return json_encode($response);
    }


    public function update(Request $request, $id)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];

        $productName  = $request->input('name');
        $productType  = $request->input('type');
        $productPrice = $request->input('price');

        if (!$error) {
            $inputProducts = PRD::find($id);
            $inputProducts->name  = $productName;
            $inputProducts->type  = $productType;
            $inputProducts->price = $productPrice;
            $update = $inputProducts->save();
            if ($update) {
                return redirect()->route('products.index');
            } else {
                return redirect()->route('products.index');
            }
        }
        // $resp = [
        //     'status' => $status,
        //     'message' => $message,
        //     'data' => $data,
        //     'errors' => $error,
        // ];

        // return response()->json($resp, 200);
    }


    public function destroy($id)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];
        $product = PRD::find($id);
        $delete = $product->delete();
        if ($delete) {
            $error = false;
            $status = 200;
            $message = 'Delete Success';
        } else {
            $error = false;
            $status = 210;
            $message = 'Ops, Something wrong';
        }

        $resp = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $error,
        ];
        return response()->json($resp, 200);
    }

    public function addStock(Request $request, $id)
    {
        $status = 200;
        $message = null;
        $error = false;
        $data = [];

        $newStock = $request->input('stockVal');

        $product = PRD::find($id);
        $product->stock = (int)$newStock;
        $addstock = $product->save();
        if ($addstock) {
            $error = false;
            $status = 200;
            $message = 'Change Stock Success';
        } else {
            $error = false;
            $status = 210;
            $message = 'Ops, Something wrong';
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
