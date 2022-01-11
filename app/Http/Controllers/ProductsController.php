<?php

namespace App\Http\Controllers;

use App\Models\Products as PRD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
                    'product_id' => $dt->product_id,
                    'name' => $dt->name,
                    'brand' => $dt->brand,
                    'price' => $dt->price,
                    'stock' => $dt->stock,
                    'created' => date('d/m/Y - H:i', strtotime($dt->created_at))
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
        $productBrand = $request->input('brand');

        //CREATE PRODUCT ID
        $rNmbr1 = substr($productName, 0, 3);
        $rNmbr2 = substr($productBrand, 0, 3);
        $rNmbr3 = strtoupper($rNmbr1 . $rNmbr2);
        $rNmbr4 = rand(10, 99);
        $rNmbr5 = date('ymdHis');
        $productId =  $rNmbr3 . $rNmbr4 . $rNmbr5;

        if (!$error) {
            $inputProducts = new PRD;
            $inputProducts->product_id = $productId;
            $inputProducts->name  = $productName;
            $inputProducts->brand = $productBrand;
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
        $findData = PRD::where('product_id', $id)->get();
        foreach ($findData as $dt):
            $data[] = [
                'product_id' => $dt->product_id,
                'name' => $dt->name,
                'brand' => $dt->brand,
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
        $productBrand = $request->input('brand');
        $productPrice = $request->input('price');

        if (!$error) {
            $inputProducts = PRD::find($id);
            $inputProducts->name  = $productName;
            $inputProducts->brand = $productBrand;
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
