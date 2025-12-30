<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class Countdowns extends Controller
{

    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function countdown()
    {
        return view("admin.countdowns.countdowns");
    }

    public function storecountdown(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'end_datetime' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
        ];

        // VALIDATE

        // DELETE PREVIOUS COUNTDOWN IF EXISTS
        \App\Models\Countdowns::truncate();

        $imagepath = [
            'image' => 'countdown/images',
        ];



        // CREATE NEW COUNTDOWN
        $this->service->store($request, $rules, \App\Models\Countdowns::class, $imagepath);

        return response()->json([
            'message' => 'New Countdown created successfully!',
            'status' => 'success',
        ]);
    }
}
