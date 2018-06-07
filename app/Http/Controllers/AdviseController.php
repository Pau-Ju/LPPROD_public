<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;


class AdviseController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $user_id = (int)Auth::user()->id;
        $favorites = DB::table('series')->join('favorites', 'series.id_Serie', '=', 'favorites.id_Favorite_Serie')
            ->where('favorites.id_Favorite_User','=', $user_id)->get();

        $interestedInto = DB::SELECT("(SELECT distinct s.name FROM series s, favorites f WHERE s.id_Serie = f.id_Favorite_Serie AND f.id_Favorite_User = ".$user_id." )
                        UNION(SELECT distinct s.name FROM series s, notes n WHERE s.id_Serie = n.id_Notes_Serie AND n.id_Notes_User = ".$user_id."
                        AND n.note > 4)");

        $favorites= $this->createList($favorites, 'name');

        if(count($interestedInto)) {

            $data = DB::select("with numerator as (
                              SELECT pFAV.id_Post_Serie as idFavoriteSerie, pOther.id_Post_Serie as idOtherSerie,
                              sum(pFAV.term_Frequency * k.idf * pOther.term_Frequency * k.idf) as numValue
                              FROM posting pFAV, posting pOther, keywords k
                              WHERE pFAV.id_Post_Keyword = pOther.id_Post_Keyword
                              AND pFAV.id_Post_Keyword = k.id_Word
                              AND pFAV.id_Post_Serie <> pOther.id_Post_Serie
                              AND pFAV.id_Post_Serie  in (SELECT id_Serie
                                                        FROM series
                                                        WHERE name in " . $favorites . ")                     
                              GROUP BY pFAV.id_Post_Serie, pOther.id_Post_Serie)
                            
                            SELECT s.id_Serie as id, s.name as name, n.numValue / (
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idFavoriteSerie))
                                                  *
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idOtherSerie))) score, 
                                                        ROUND(AVG(notes.note), 1) as moyenne,
                                                        s.image_link as image_link,
                                                        ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note
                                                        
                              FROM numerator n, series s, notes 
                              WHERE n.idOtherSerie = s.id_Serie
                              AND s.id_Serie = notes.id_Notes_Serie
                              GROUP BY s.name, s.image_link, score, id
                              ORDER BY 2 DESC, 1;");

        }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 12;

            $path = LengthAwarePaginator::resolveCurrentPath();

            $series = new LengthAwarePaginator(array_slice($data, $perPage * ($currentPage - 1), $perPage), count($data), $perPage, $currentPage, ['path' => $path]);



        return view('advise', compact( 'series'));
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     *
     * @param $data
     * @return string
     */
    public function createList($data, $column){
        $return=" (";
        foreach ($data as $item){
            $return .= "'". $item->$column ."', ";
        }
        $return = substr($return, 0, -2) .") ";
        return $return;
    }
}