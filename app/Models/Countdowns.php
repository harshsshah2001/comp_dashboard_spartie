<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countdowns extends Model
{
    protected $table = 'countdowns';

    protected $fillable = [
        'title',
        'subtitle',
        'end_datetime',
        'image',
        'status',
    ];
}
