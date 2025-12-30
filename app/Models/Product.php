<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category',
        'productname',
        'image',
        'badge',
        'icon',
        'multipleimage',
        'productdescription',
        'price',
        'saleprice',
    ];

    //  public function subProducts()
    // {
    //     return $this->hasMany(SubProduct::class, 'product_id');
    // }
}
