<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubProductController extends Controller
{
    public function subproductform(){
        return view('admin.sub-product.create_subproduct');
    }
}
