<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Note;
use App\Comment;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    /**
     * @param Request $request
     */
    public function notation(Request $request){
        $user_id = (int)Auth::user()->id;
        $serie = $request->get('idSerie');
        $note = $request->get('note');

        $exist = Note::where('id_Notes_Serie', $serie)->where('id_Notes_User',  $user_id)->get();


        if(count($exist)){
            Note::where('id_Notes_Serie', $serie)
                ->where('id_Notes_User', $user_id)
                ->update(['note' => $note]);

        }else{
            $newNote = new Note();
            $newNote->id_Notes_Serie = $serie;
            $newNote->id_Notes_User = $user_id;
            $newNote->note=$note;

            $newNote->save();
        }
    }


    /**
     * @param Request $request
     */
    public function favorites(Request $request){

        $user_id = (int)Auth::user()->id;
        $idSerie = $request->get('idSerie');
        $state = $request->get('state');

        if($state==1){
            $newFav = new Favorite();
            $newFav->id_Favorite_Serie = $idSerie;
            $newFav->id_Favorite_User = $user_id;

            $newFav->save();
        }else{
            $affectedRows = Favorite::where('id_Favorite_Serie', $idSerie)->where('id_FAvorite_User', $user_id)->delete();
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getFavorites(Request $request){
        $user_id = (int)Auth::user()->id;
        $serie = $request->get('id');

        $exist = Favorite::where('id_Favorite_Serie', $serie)->where('id_Favorite_User',  $user_id)->get();


        if(count($exist)){
            return response(1);
        }else{
            return response(0);
        }
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request){
        $user_id = (int)Auth::user()->id;
        $serie = $request->get('id');

        Favorite::where('id_Favorite_Serie', $serie)->where('id_Favorite_User',  $user_id)->delete();
    }





    public function comment(Request $request){
        $user_id = (int)Auth::user()->id;
        $idSerie = $request->get('idSerie');
        $comment = $request->get('comment');

        $exist = Comment::where('id_Comment_User', $user_id)->where('id_Comment_Serie', $idSerie)->get();

        if(count($exist)!=0){
            $affectedRows = Comment::where('id_Comment_User', $user_id)
                ->where('id_Comment_Serie', $idSerie)
                ->update(['comment' => $comment]);
        }else{
            $newComment = new Comment();
            $newComment->id_Comment_User = $user_id;
            $newComment->id_Comment_Serie = $idSerie;
            $newComment->comment =$comment;
            $newComment->save();
        }

    }

}
