<?php

namespace App\Http\Controllers;

use App\Serie;
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
    public function index(){
        $data=[];
        $unique_data=[];
        $user_id = (int)Auth::user()->id;

        $interestedInto = Serie::getInterests($user_id);
        $interest = $this->createList($interestedInto, 'name');

        if(count($interestedInto)) {
            $data = Serie::getAdvise($user_id, $interest);
        }

            foreach ($data as $item=>$value){
                array_push($unique_data, $value->id_Serie);
            }
            $unique_data = array_unique($unique_data);
            $ids = $this->createListWithoutColumn($unique_data);

            $data = Serie::getUniqueAdvise($user_id,$ids);

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

    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     *
     * @param $data
     * @return string
     */
    public function createListWithoutColumn($data){
        $return=" (";
        foreach ($data as $item){
            $return .=  $item .", ";
        }
        $return = substr($return, 0, -2) .") ";
        return $return;
    }
}