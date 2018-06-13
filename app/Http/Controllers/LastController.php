<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::id()) {
            $user_id = (int)Auth::user()->id;
            $last = Serie::getSeriesLastLogged($user_id);
        }else{
            $last = Serie::getSeriesLast();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;
        $path=LengthAwarePaginator::resolveCurrentPath();
        $series = new LengthAwarePaginator(array_slice($last, $perPage * ($currentPage - 1), $perPage), count($last), $perPage, $currentPage,['path'=>$path]);

        return view('last', compact('series'));
    }
}