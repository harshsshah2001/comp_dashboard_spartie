<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'sliderimage',
        'mobilesliderimage',
        'sliderheading',
        'slidersubheading',
        'sliderdescription',
        'buttontext',
        'buttonlink',
        'headingcolor',
        'subheadingcolor',
        'descriptioncolor',
        'buttonbgcolor',
    ];
}
