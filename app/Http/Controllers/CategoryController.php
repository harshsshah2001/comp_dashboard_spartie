<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AdminService;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{

    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    // this is use for datatable's
    public function list()
    {
        $categories = Category::all();

        return response()->json([
            'data' => $categories
        ]);
    }

    public function categoryform(Request $request)
    {

        $categories = Category::all();

        // For dropdown only (title)
        $categoryTitles = Category::select('categoryTitle')->get();

        // Normal HTTP request → return view
        return view('admin.category.create_category', compact('categoryTitles'));
    }

    public function titles()
{
    $cats = Category::all();              // fetch all categories
    $result = $this->buildHierarchy($cats); // build hierarchy
    return response()->json($result);       // return hierarchical list
}


    private function buildHierarchy($categories, $parent = "")
    {
        $output = [];

        foreach ($categories as $cat) {

            // Match parent title as string
            if ($cat->parentCategory == $parent) {

                $output[] = [
                    "title" => ($parent == "" ? "" : "— ") . $cat->categoryTitle,
                    "original" => $cat->categoryTitle
                ];

                // Recursively find children
                $children = $this->buildHierarchy($categories, $cat->categoryTitle);

                foreach ($children as $child) {
                    $output[] = [
                        "title" => "— " . $child["title"],  // add indent
                        "original" => $child["original"]
                    ];
                }
            }
        }

        return $output;
    }

    public function store(Request $request)
    {

        
        $validation_rules = [
            'parentCategory' => 'nullable|string',
            'categoryTitle'  => 'required|string|max:255|min:3',
            'image'          => 'required|nullable|image',
            'icon'           => 'nullable|image',
            'categoryDescription' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $image_paths = [
            'icon'  => 'categories/icons',
            'image' => 'categories/images'
        ];

        return $this->service->store(
            $request,
            $validation_rules,
            \App\Models\Category::class,
            $image_paths
        );
    }



    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $model = \App\Models\Category::class;

        $validation_rules = [
            'parentCategory'       => 'nullable|string',
            'categoryTitle'        => 'required|string|max:255',
            'image'                => 'nullable|image',
            'icon'                 => 'nullable|image',
            'categoryDescription'  => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $paths = [
            'image' => 'categories',
            'icon'  => 'category_icons'
        ];

        $updated = $this->service->update($request, $validation_rules, $model, $id, $paths);

        if ($updated) {
            return response()->json(['status' => true, 'message' => 'Category Updated Successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Update Failed']);
    }

    public function delete($id)
    {
        $model = \App\Models\Category::class;

        // Fields that contain image paths in DB
        $image_fields = ['image', 'icon'];

        return $this->service->delete($model, $id, $image_fields);
    }

    public function chart()
    {
        // Fetch category titles & count how many are in each parent category
        $chartData = Category::select('parentCategory')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('parentCategory')
            ->get();

        return view('admin.category.chart', compact('chartData'));
    }
}
