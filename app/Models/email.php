<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    protected $table = 'emails';
    public $timestamps = false;
    protected $fillable = [
        'email',
        'subscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];
}
