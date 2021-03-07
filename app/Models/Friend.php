<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id',
        'to_id',
    ];

    public function getTimeAgo($carbonObject)
    {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week', 'ago'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w', ''],
            $carbonObject->diffForHumans()
        );
    }
}
