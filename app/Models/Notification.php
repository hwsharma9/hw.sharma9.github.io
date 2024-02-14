<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    /**
     * Cast variables to specified data types
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'id' => 'string'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }
}
