<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        return view('home',compact('arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
}
