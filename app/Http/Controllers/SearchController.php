<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Facades\DB;


class SearchController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = explode(" ", $request->get('s'));

        $in = "";
        for($i =0; $i < count($query) ;$i++){
            $in = $in ."'". $query[$i] ."'". ',';
        }
        $in = substr($in,0, -1);
/*
        $data = DB::table('series as s')->whereIn('k.libelle', $in)
                        ->join('posting as p', 'p.id_Post_Serie', '=', 's.id_Serie')
                        ->join('keywords as k', 'p.id_Post_Keyword', '<>', 'k.id_Word')
                        ->orderBy('score', 'DESC')
                        ->orderBy('s.name', 'ASC')
                        ->select('s.id_Serie as id, s.name, s.image_link as url, s.release_date as release, sum(p.term_Frequency * k.idf) as score')
                        ->groupBy(array('id', 'name', 'url', 'release'))->get();
        */
        $series=DB::select("SELECT s.id_Serie as id, s.name, s.image_link as url, sum(p.term_Frequency * k.idf) as score
                            FROM posting p, series s, keywords k
                            WHERE p.id_Post_Serie = s.id_Serie
                            AND p.id_Post_Keyword = k.id_Word
                            AND k.libelle in (". $in .")
                            GROUP BY s.id_Serie , s.name,s.image_link
                            ORDER BY 2 DESC, 1;");

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $series= new LengthAwarePaginator(array_slice($series, $perPage * ($currentPage - 1), $perPage), count($series), $perPage, $currentPage,
            ['path'=>$path, 'query'=> $request->query()
            ]);


        return view('results', compact('series'));
    }
}