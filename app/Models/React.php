<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class React extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
    ];



    
    public function post()         { return $this->belongsTo('App\Models\Post');}
    public function user()         { return $this->belongsTo('App\Models\User');}
}

