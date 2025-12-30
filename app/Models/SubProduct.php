<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProduct extends Model
{

    protected $fillable = [
        'product_id',
        'product_name',
        'product_image',
        'product_icon',
        'product_price',
        'product_saleprice',
        'product_quantity',
        'product_size',
        'product_description',
        'product_sortdescription',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
