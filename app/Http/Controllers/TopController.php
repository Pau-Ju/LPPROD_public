<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::id()){

            $user_id = (int)Auth::user()->id;

            $top = Serie::getSeriesTopLogged($user_id);
        }else{
            $top = Serie::getSeriesTop();
        }


        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $series = new LengthAwarePaginator(array_slice($top, $perPage * ($currentPage - 1), $perPage), count($top), $perPage, $currentPage,['path'=>$path]);


        return view('top', compact( 'series'));
    }
}