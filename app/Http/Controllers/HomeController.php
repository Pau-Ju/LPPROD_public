<?php

namespace App\Http\Controllers;

use App\Serie;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
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
            $series = Serie::getSeriesHomeLogged($user_id);
        }else{
            $series = Serie::getSeriesHome();
        }





        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $series = new LengthAwarePaginator(array_slice($series, $perPage * ($currentPage - 1), $perPage), count($series), $perPage, $currentPage,['path'=>$path]);

        return view('home', compact('series'));
    }
}
