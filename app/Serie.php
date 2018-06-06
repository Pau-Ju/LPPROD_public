<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_Serie
 * @property string $name
 * @property int $maxNB
 * @property string $image_link
 * @property string $release_date
 * @property Comment[] $comments
 * @property User[] $users
 * @property Note[] $notes
 * @property Posting[] $postings
 * @property Season[] $seasons
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
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'maxNB', 'image_link', 'release_date'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seasons()
    {
        return $this->hasMany('App\Season', 'id_Season_Serie', 'id_Serie');
    }
}
