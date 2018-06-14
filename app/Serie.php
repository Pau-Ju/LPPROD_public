<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id_Serie
 * @property string $name
 * @property int $maxNB
 * @property string $image_link
 * @property string $release_date
 * @property string $author
 * @property string $synopsis
 * @property Comment[] $comments
 * @property User[] $users
 * @property Note[] $notes
 * @property Posting[] $postings
 */
class Serie extends Model
{

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_Serie';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'maxNB', 'image_link', 'release_date', 'author', 'synopsis'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'id_Comment_Serie', 'id_Serie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'favorites', 'id_Favorite_Serie', 'id_Favorite_User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Note', 'id_Notes_Serie', 'id_Serie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postings()
    {
        return $this->hasMany('App\Posting', 'id_Post_Serie', 'id_Serie');
    }

    /*---------------------- Special Functions ----------------------*/
    /**
     * @param $user_id
     * @return mixed
     */
    public static function getSeriesHomeLogged($user_id){
        $series = DB::SELECT("(SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                             ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note

                             FROM series as s, notes as notes
                             WHERE s.id_Serie = notes.id_Notes_Serie
                             GROUP BY s.name, s.image_link, s.id_Serie
                             ORDER BY s.name)
                             union
                             (SELECT se.name as name, se.id_Serie as id_Serie, se.image_link as image_link, 3 as moyenne, 0 as note
                             FROM series se
                             WHERE se.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                             GROUP BY se.name, se.image_link, se.id_Serie)
                             ORDER BY name");
        return $series;
    }


    /**
     * @return mixed
     */
    public static function getSeriesHome(){
        $series = DB::SELECT("(SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne
                             FROM series as s, notes as notes
                             WHERE s.id_Serie = notes.id_Notes_Serie
                             GROUP BY s.name, s.image_link, s.id_Serie
                             ORDER BY s.name)
                             union
                             (SELECT se.name as name, se.id_Serie as id_Serie, se.image_link as image_link, 3 as moyenne
                             FROM series as se
                             WHERE se.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                             GROUP BY se.name, se.image_link, se.id_Serie
                             ORDER BY se.name)");
        return $series;
    }

    public static function getSeriesTopLogged($user_id){
        $series = DB::select("(SELECT s.name as name, s.image_link as image_link, s.id_Serie as id_Serie,
                            cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                             ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note
                            FROM notes notes, series s
                            WHERE s.id_Serie = notes.id_Notes_Serie
                            GROUP BY name, id_Serie, image_link
                            HAVING avg(notes.note)>3.5
                            ORDER BY moyenne desc)
                            ");
        return $series;
    }

    public static function  getSeriesTop(){
        $series = DB::select("(SELECT s.name as name, s.image_link as image_link, s.id_Serie as id_Serie,
                            cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne
                            FROM notes notes, series s
                            WHERE s.id_Serie = notes.id_Notes_Serie
                            GROUP BY s.image_link, s.name, s.id_Serie 
                            HAVING avg(notes.note)>3.5
                            ORDER BY moyenne desc)");
        return $series;
    }

    public static function getSeriesLastLogged($user_id){
        $series = DB::select("SELECT tab.name name, tab.id_Serie id_Serie, tab.image_link image_link, tab.moyenne moyenne, tab.note, tab.release_date from ((
                                SELECT s.name as name, s.id_Serie as id_Serie , s.image_link as image_link,cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                                 ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note,
                                 s.release_date release_date
                                FROM series s, notes notes
                                WHERE s.id_Serie = notes.id_Notes_Serie
                                GROUP BY s.name, s.id_Serie, s.image_link, s.release_date )
                              
                                union
                                 (SELECT se.name as name, se.id_Serie as id_Serie, se.image_link as image_link, 3 as moyenne, 0 as note, se.release_date release_date
                                 FROM series as se
                                 WHERE se.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
                                                         FROM notes )
                                 GROUP BY se.name, se.id_Serie, se.image_link, se.release_date )) as tab
                                 ORDER BY tab.release_date desc ");
        return $series;
    }

    public static function getSeriesLast(){
        $series = DB::select("SELECT tab.name name, tab.id_Serie id_Serie, tab.image_link image_link, tab.moyenne moyenne, tab.release_date release_date from ( (
                                SELECT s.name as name, s.id_Serie as id_Serie , s.image_link as image_link,cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne, 
                                s.release_date release_date
                                FROM series s, notes notes
                                WHERE s.id_Serie = notes.id_Notes_Serie
                                GROUP BY s.name, s.image_link, s.id_Serie, s.release_date)
                                union
                                 (SELECT se.name as name, se.id_Serie as id_Serie, se.image_link as image_link, 3 as moyenne, se.release_date 
                                 FROM series se
                                 WHERE se.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
                                                           FROM notes )
                                 GROUP BY se.name, se.image_link, se.id_Serie, se.release_date )) as tab
                                 ORDER BY tab.release_date desc ");
        return $series;
    }


    public static function getInterests($user_id){
        $series = DB::SELECT("(SELECT distinct s.name FROM series s, favorites f WHERE s.id_Serie = f.id_Favorite_Serie AND f.id_Favorite_User = ".$user_id." )
                        UNION(SELECT distinct s.name FROM series s, notes n WHERE s.id_Serie = n.id_Notes_Serie AND n.id_Notes_User = ".$user_id."
                        AND n.note >= 4)");
        return $series;
    }


    public static function getAdvise($user_id, $interests){
        $series = DB::select("with numerator as (
                              SELECT distinct pFAV.id_Post_Serie as idFavoriteSerie, pOther.id_Post_Serie as idOtherSerie,
                              sum(pFAV.term_Frequency * k.idf * pOther.term_Frequency * k.idf) as numValue
                              FROM posting pFAV, posting pOther, keywords k
                              WHERE pFAV.id_Post_Keyword = pOther.id_Post_Keyword
                              AND pFAV.id_Post_Keyword = k.id_Word
                              AND pFAV.id_Post_Serie <> pOther.id_Post_Serie
                              AND pFAV.id_Post_Serie  in (SELECT id_Serie
                                                        FROM series
                                                        WHERE name in " . $interests . ")                     
                              GROUP BY pFAV.id_Post_Serie, pOther.id_Post_Serie)
                            
                            (SELECT distinct s.id_Serie as id_Serie, s.name as name, n.numValue / (
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idFavoriteSerie))
                                                  *
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idOtherSerie))) score, 
                                                        cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                                                        s.image_link as image_link,
                                                        ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note
                                                        
                              FROM numerator n, series s, notes 
                              WHERE n.idOtherSerie = s.id_Serie
                              AND s.id_Serie = notes.id_Notes_Serie
                              AND s.name not in ".$interests."
                              GROUP BY s.name, s.image_link, score, id_Serie
                              ORDER BY score DESC)
                              UNION 
                              (SELECT distinct s.id_Serie as id_Serie, s.name as name, n.numValue / (
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idFavoriteSerie))
                                                  *
                                                  sqrt((SELECT sum(power(term_Frequency * idf, 2))
                                                        FROM posting p, keywords k
                                                        WHERE p.id_Post_Keyword = k.id_word
                                                        AND p.id_Post_Serie = n.idOtherSerie))) score, 
                                                        3 as moyenne,
                                                        s.image_link as image_link,
                                                        0 as note
                                                        
                              FROM numerator n, series s
                              WHERE n.idOtherSerie = s.id_Serie
                              AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                              AND s.name not in ".$interests."
                              GROUP BY s.name, s.image_link, score, id_Serie
                              ORDER BY score DESC)
                              ");

        return $series;
    }


    public static function getUniqueAdvise($user_id, $ids){
            $series = DB::SELECT("(SELECT distinct s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                                    ROUND((SELECT distinct no.note 
                                                            FROM notes no 
                                                            WHERE no.id_Notes_User = ".$user_id."
                                                            AND no.id_Notes_Serie = s.id_Serie), 1) as note
                             FROM series as s, notes as notes
                             WHERE s.id_Serie = notes.id_Notes_Serie
                             AND s.id_Serie in ".$ids."
                             GROUP BY s.name, s.image_link, s.id_Serie
                             ORDER BY s.name)
                             union
                             (SELECT distinct se.name as name, se.id_Serie as id_Serie, se.image_link as image_link, 3 as moyenne, 0 as note
                             FROM series as se
                             WHERE se.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
													 AND se.id_Serie in ".$ids."
                             GROUP BY se.name, se.image_link, se.id_Serie
                             ORDER BY se.name)");
            return $series;
    }


    public  static function getFavorites($user_id){
        $series = DB::SELECT("(SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne,
                             ROUND((SELECT distinct no.note 
                                    FROM notes no 
                                    WHERE no.id_Notes_User = ".$user_id."
                                    AND no.id_Notes_Serie = s.id_Serie), 1) as note
                             FROM series s, favorites f, notes notes
                             WHERE s.id_Serie = f.id_Favorite_Serie
                             AND notes.id_Notes_Serie = f.id_Favorite_Serie
                             AND f.id_Favorite_User = ".$user_id."                
                             AND notes.id_Notes_User = f.id_Favorite_User
                             GROUP BY s.name, id_Serie, image_link)
                             UNION
                             (SELECT s.name as name, s.id_Serie as id_Serie, s.image_link as image_link, 3 as moyenne,0 as note
                             FROM series s, favorites f 
                             WHERE s.id_Serie = f.id_Favorite_Serie
                             AND f.id_Favorite_User = ".$user_id."
                             AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                             GROUP BY name, id_Serie, image_link)
                             ");
        return $series;
    }



    public static function getSearchResults($in){
        $series = DB::select("(SELECT s.id_Serie as id_Serie, s.name, s.image_link as url, sum(p.term_Frequency * k.idf) as score,
                                cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne
                                FROM posting p, series s, keywords k, notes notes
                                WHERE p.id_Post_Serie = s.id_Serie
                                AND p.id_Post_Keyword = k.id_Word
                                AND notes.id_Notes_Serie = s.id_Serie
                                AND k.libelle in (". $in .")
                                GROUP BY s.id_Serie , s.name,s.image_link
                                ORDER BY 2 DESC, 1)
                                UNION 
                                (SELECT s.id_Serie as id_Serie, s.name, s.image_link as url, sum(p.term_Frequency * k.idf) as score,
                                3 as moyenne
                                FROM posting p, series s, keywords k, notes notes
                                WHERE p.id_Post_Serie = s.id_Serie
                                AND p.id_Post_Keyword = k.id_Word
                                AND k.libelle in (". $in .")
                                AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie 
													 FROM notes )
                                GROUP BY s.id_Serie , s.name,s.image_link
                                ORDER BY 2 DESC, 1)");
        return $series;
    }


    public static function getSearchResultsLogged($user_id, $in){
        $series = DB::select("(SELECT s.id_Serie as id_Serie, s.name, s.image_link as url, sum(p.term_Frequency * k.idf) as score, 
+
                                cast(round(2*avg(notes.note))/2 as decimal(2,1)) as moyenne, 
                                ROUND((SELECT distinct no.note FROM notes no WHERE no.id_Notes_User = " . $user_id . " and no.id_Notes_Serie = s.id_Serie), 1) as note 
                                FROM posting p, series s, keywords k, notes notes 
                                WHERE p.id_Post_Serie = s.id_Serie 
                                AND p.id_Post_Keyword = k.id_Word 
                                AND notes.id_Notes_Serie = s.id_Serie 
                                AND k.libelle in (". $in .") 
                                GROUP BY s.id_Serie , s.name,s.image_link 
                                ORDER BY 2 DESC, 1) 
                                UNION  
                                (SELECT s.id_Serie as id_Serie, s.name, s.image_link as url, sum(p.term_Frequency * k.idf) as score, 
                                3 as moyenne, 0 as note 
                                FROM posting p, series s, keywords k 
                                WHERE p.id_Post_Serie = s.id_Serie 
                                AND p.id_Post_Keyword = k.id_Word 
                                AND k.libelle in (". $in .") 
                                AND s.id_Serie not in (SELECT  distinct notes.id_Notes_Serie as id_Serie  
                           FROM notes ) 
                                GROUP BY s.id_Serie , s.name,s.image_link 
                                ORDER BY 2 DESC, 1)");
        return $series;
    }
}
