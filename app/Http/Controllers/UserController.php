<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Countdowns;
use App\Models\Imagebox;
use App\Models\Infocards;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use Nette\Utils\Image;
use Symfony\Polyfill\Intl\Idn\Info;

class UserController extends Controller
{
    public function Homepage()
    {
        $allcategories = Category::all();
        $allproducts = Product::all();
        $imageboxs = Imagebox::all();
        $sliders = Slider::all();
        $countdowns = Countdowns::where('status', 1)->latest()->first();
        $infocards = Infocards::all();
        $blogs = Blog::all();
        return view('dashboard.dashboard', compact('allcategories', 'allproducts', 'imageboxs', 'sliders', 'countdowns','infocards','blogs'));
    }

    
}
