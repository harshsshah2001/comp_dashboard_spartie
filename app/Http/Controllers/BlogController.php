<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class BlogController extends Controller
{

    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }


    public function blog(){
        return view("admin.blog.blog");
    }
    public function storeblog(Request $request){
        $rules = [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];

        $image = [
            'image'=>'blog/images',
        ];

        $this->service->store($request,$rules,\App\Models\Blog::class,$image);

        return response()->json([
            'message' => 'New Blog Created Successfully!',
            'status' => 'success',
        ]);
    }
}
