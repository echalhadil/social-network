<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [

        'from_id',
        'to_id',
       

    ];
    protected $encryptable = [
        'last_message',
    ];

    public function getTimeAgo($carbonObject)
    {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week', 'ago'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w', ''],
            $carbonObject->diffForHumans()
        );
    }

    // returs all conversation's messages
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
}
