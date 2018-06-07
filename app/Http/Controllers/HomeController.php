<?php

namespace App\Http\Controllers;

use App\Serie;
use \Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $series= Serie::paginate(12);
        return view('home', compact('series'));
    }
}
