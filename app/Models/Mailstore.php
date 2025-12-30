<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailstore extends Model
{
    protected $table = "mailstores";

    protected $fillable = ['email'];
}
