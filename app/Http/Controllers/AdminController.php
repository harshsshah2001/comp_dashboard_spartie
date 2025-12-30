<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function signupinform()
    {
        return view('admin.auth.registerform');
    }

    public function registerpost(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|min:2'
        ]);

        // Prepare data (hashed password)
        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Save record
        $save = Admin::create($data);

        if ($save) {
            return view('admin.auth.login');
        }

        return "Data is not submitted";
    }

    public function signinform()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('userlist')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            // regenerate session
            $request->session()->regenerate();

            // store email in session
            session(['user_email' => Auth::guard('userlist')->user()->email]);

            return response()->json([
                'status'   => 'success',
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid email or password'
        ], 401);
    }


    public function imagebox()
    {
        return view('admin.imagebox.imagebox');
    }

    public function storeImagebox(Request $request)
    {
        $rules = [
            'imageboxtitle' => 'required|string|max:255|min:2',
            'image' => 'required|image',
        ];

        $image_paths = [
            'image' => 'imagebox/images'
        ];

        return $this->service->store(
            $request,
            $rules,
            \App\Models\Imagebox::class,
            $image_paths
        );
    }

    public function slider()
    {
        return view('admin.slider.slider');
    }

    public function storeslider(Request $request)
    {
        $rules = [
            'sliderimage'        => 'required|image',
            'mobilesliderimage'  => 'required|image',

            'sliderheading'      => 'nullable|string|max:255',
            'slidersubheading' => 'nullable|string|max:255',

            'sliderdescription'  => 'nullable|string',

            'buttontext'         => 'nullable|string|max:255',
            'buttonlink'         => 'nullable|string|max:255',

            'headingcolor'       => 'nullable|string',
            'subheadingcolor'    => 'nullable|string',
            'buttonbgcolor'      => 'nullable|string',
            'descriptioncolor'   => 'nullable|string',
        ];

        // image paths for dynamic service
        $image_paths = [
            'sliderimage'       => 'slider/images',
            'mobilesliderimage' => 'slider/mobile_images',
        ];

        // Call dynamic store() service
        return $this->service->store(
            $request,
            $rules,
            \App\Models\Slider::class,
            $image_paths
        );
    }
}
