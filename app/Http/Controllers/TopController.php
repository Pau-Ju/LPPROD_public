<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
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

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $pagination = new LengthAwarePaginator(array_slice($top, $perPage * ($currentPage - 1), $perPage), count($top), $perPage, $currentPage,['path'=>$path]);


        return view('top', compact('top', 'pagination'));
    }
}