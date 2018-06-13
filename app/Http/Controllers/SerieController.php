<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
class SerieController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id, $name)
    {


        if (Auth::id()) {
            $user_id = (int)Auth::user()->id;
            $series = DB::Select("(SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, s.author as author, s.synopsis as synopsis,s.release_date as release_date,
                                 cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne, 
                                 ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note
                                 FROM series s, notes notes
                                 WHERE s.id_Serie=" . $id . "
                                 AND s.id_Serie = notes.id_Notes_Serie
                                 GROUP BY s.name, s.id_Serie, s.image_link, s.author, s.synopsis, s.release_date)
                                 UNION
                                 (SELECT s.name name, s.id_Serie id_Serie, s.image_link image_link, s.author as author, s.synopsis as synopsis,s.release_date as release_date,
                                 3 as moyenne, 0 as note
                                 FROM series s
                                 WHERE s.id_Serie=" . $id . "
                                 AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes)
                                 GROUP BY s.name, s.id_Serie, s.image_link, s.author, s.synopsis, s.release_date)
                                 ");
        } else {
            $series = DB::Select("(SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link,s.author as author, s.synopsis as synopsis,s.release_date as release_date,
                                 cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne 
                                 FROM series s, notes notes
                                 WHERE s.id_Serie=" . $id . "
                                 AND s.id_Serie = notes.id_Notes_Serie
                                 GROUP BY s.name, s.id_Serie, s.image_link, s.author, s.synopsis, s.release_date)
                                 UNION 
                                 (SELECT s.name name, s.id_Serie id_Serie, s.image_link image_link,s.author as author, s.synopsis as synopsis,s.release_date as release_date,
                                 3 as moyenne
                                 FROM series s
                                 WHERE s.id_Serie=" . $id . "
                                 AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                                 GROUP BY s.name, s.id_Serie, s.image_link, s.author, s.synopsis, s.release_date)
                                 ");
        }


        $comments = DB::SELECT("SELECT u.name as name, c.comment as comment FROM users u, comments c WHERE u.id = c.id_Comment_User AND c.id_Comment_Serie=".$id);


        return view('serie', compact('series', 'comments'));
    }
}

