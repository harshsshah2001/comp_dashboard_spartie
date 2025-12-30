<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infocards extends Model
{
    public $table = 'infocards';

    public $fillable = [
        'image',
        'icon',
        'title',
        'description',
    ];

}
