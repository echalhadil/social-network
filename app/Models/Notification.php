<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'maker_id',
        'target_id',
        'type',
        'post_id',

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


    // return Notification maker
    public function maker()
    {
        return $this->belongsTo('App\Models\User');
    }

    // return Notification target
    public function target()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getTimeAgo($carbonObject)
    {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week', 'ago'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w', ''],
            $carbonObject->diffForHumans()
        );
    }
}
