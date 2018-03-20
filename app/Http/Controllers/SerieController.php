<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
class SerieController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id, $name)
    {
        $serie = DB::table('series')->select('name', 'id_Serie as id', 'image_link as url')->where('id_Serie', '=', $id)->first();

        return view('serie', compact('serie'));
    }
}