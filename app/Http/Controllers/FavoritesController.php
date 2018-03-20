<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
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
        $data = DB::table('series')->join('favorites', 'series.id_Serie', '=', 'favorites.id_Favorite_Serie')
                ->where('favorites.id_Favorite_User','=', $user_id)->paginate(12);


        return view('favorites', compact('data', 'user_id'));
    }
}