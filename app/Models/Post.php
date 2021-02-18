<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 
        'picture', 
        'user_id',
    ];
   
    
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // returs all post's comments
    public function comments()  {return $this->hasMany('App\Models\Comment');}

    // returs all post's likes
    // public function likes()     {return $this->HasMany('App\Models\Like' );}
    public function reacts()     {return $this->HasMany('App\Models\React' );}

    // Returns the post owner
    public function user()      {return $this->belongsTo('App\Models\User');}


    public function getTimeAgo($carbonObject) {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week','ago'], 
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w',''], 
            $carbonObject->diffForHumans()
        );
    }
    
}
