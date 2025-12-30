<?php

namespace App\Http\Controllers;

use App\Models\Infocards;
use App\Services\AdminService;
use Illuminate\Http\Request;

class InfocardsController extends Controller
{
    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function infocards()
    {
        return view("admin.infocards.infocards");
    }

public function storeinfocards(Request $request)
{
    // Validation rules
    $rules = [
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|required_without:icon',
        'icon'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|required_without:image',
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ];

    $messages = [
        'image.required_without' => 'Upload either Image or Icon.',
        'icon.required_without'  => 'Upload either Image or Icon.',
    ];

    // Validate
    $request->validate($rules, $messages);

    // ❌ BOTH uploaded → error
    if ($request->hasFile('image') && $request->hasFile('icon')) {
        return response()->json([
            'status' => false,
            'errors' => ['You cannot upload both Image and Icon.'],
        ], 422);
    }

    // Prepare data
    $data = [
        'title' => $request->title,
        'description' => $request->description,
    ];

    // Upload IMAGE
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('infocards/images', 'public');
    }

    // Upload ICON
    if ($request->hasFile('icon')) {
        $data['icon'] = $request->file('icon')->store('infocards/icons', 'public');
    }

    // Insert into database
    Infocards::create($data);

    return response()->json([
        'status' => true,
        'message' => 'New Infocard created successfully!',
    ]);
}


}
