<?php

namespace App\Http\Controllers;


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
        $all = DB::select('SELECT s.name as name, s.image_link as url, s.id_Serie as id FROM series s');
        return view('home', compact('all'));
    }
}
