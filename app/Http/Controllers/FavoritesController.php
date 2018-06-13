<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoritesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = (int)Auth::user()->id;

        $series = Serie::getFavorites($user_id);


        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;

        $path=LengthAwarePaginator::resolveCurrentPath();

        $series = new LengthAwarePaginator(array_slice($series, $perPage * ($currentPage - 1), $perPage), count($series), $perPage, $currentPage,['path'=>$path]);

        return view('favorites', compact('series'));
    }
}