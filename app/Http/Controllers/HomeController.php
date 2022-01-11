<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    private $pagesname;
    public function __construct()
    {
        $this->pagesname = 'Dashboard';
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['headerpages'] = $this->pagesname;
        return view('home', $data);
    }
}
