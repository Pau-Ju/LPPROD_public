<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class LastController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $last = DB::select('SELECT s.name as name, s.image_link as image_link, s.id_Serie as id FROM series s
                            WHERE 1
                            ORDER BY Id_Serie DESC
                            LIMIT 12');

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $series = new LengthAwarePaginator(array_slice($last, $perPage * ($currentPage - 1), $perPage), count($last), $perPage, $currentPage,['path'=>$path]);

        return view('last', compact('series'));
    }
}