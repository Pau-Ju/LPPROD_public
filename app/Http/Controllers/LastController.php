<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\DB;
class LastController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $last = DB::select('SELECT s.name as name, s.image_link as url, s.id_Serie as id FROM series s
                            WHERE 1
                            ORDER BY Id_Serie DESC
                            LIMIT 12');

        return view('last', compact('last'));
    }
}