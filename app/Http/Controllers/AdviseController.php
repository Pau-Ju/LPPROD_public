<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
class AdviseController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = (int)Auth::user()->id;
        $favorites = DB::table('series')->join('favorites', 'series.id_Serie', '=', 'favorites.id_Favorite_Serie')
            ->where('favorites.id_Favorite_User','=', $user_id)->get();

        $favorites= $this->createList($favorites, 'name');

        $data = DB::select("with numerator as (
                              SELECT pFAV.id_Post_Serie as idFavoriteSerie, pOther.id_Post_Serie as idOtherSerie,
                              sum(pFAV.term_Frequency * k.idf * pOther.term_Frequency * k.idf) as numValue
                              FROM posting pFAV, posting pOther, keywords k
                              WHERE pFAV.id_Post_Keyword = pOther.id_Post_Keyword
                              AND pFAV.id_Post_Keyword = k.id_Word
                              AND pFAV.id_Post_Serie <> pOther.id_Post_Serie
                              AND pFAV.id_Post_Serie  in (SELECT id_Serie
                                                        FROM series
                                                        WHERE name in ".$favorites.")                     
                              GROUP BY pFAV.id_Post_Serie, pOther.id_Post_Serie
                            )
                            
                            SELECT s.name, n.numValue / (
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idFavoriteSerie))
                                                  *
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idOtherSerie))) score
                              FROM numerator n, series s
                              WHERE n.idOtherSerie = s.id_Serie
                              ORDER BY 2 DESC, 1;");



        return view('advise', compact('data', 'user_id'));
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