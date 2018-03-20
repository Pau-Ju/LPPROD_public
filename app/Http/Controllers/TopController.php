<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
class TopController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $top = DB::select('SELECT avg(note) as note, s.name as name, s.image_link as url, s.id_Serie as id
                            FROM notes n, series s
                            WHERE s.id_Serie = n.id_Notes_Serie
                            GROUP BY s.image_link, s.name, s.id_Serie HAVING avg(note)>3.5');


        return view('top', compact('top'));
    }
}