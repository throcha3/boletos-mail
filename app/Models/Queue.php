<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = "queues";

    protected $fillable = [
        'arquivo', 'email','status', 'envio'
    ];

    protected $casts = [
        'envio' => 'datetime',
    ];
}
