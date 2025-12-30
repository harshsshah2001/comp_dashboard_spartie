<?php

namespace App\Services;

use App\Repositories\AdminRepo;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    protected $repo;

    public function __construct(AdminRepo $repo)
    {
        $this->repo = $repo;
    }

    public function store($request, $validation_rules, $model, $image_paths = [])
    {
        // Validate
        $validated = $request->validate($validation_rules);

        $data = $validated;

        // Handle images dynamically
        foreach ($image_paths as $field => $path) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($path, 'public');
            }
        }

        // Add timestamps
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // Convert model class → table name
        $table = (new $model)->getTable();

        // Insert using repository
        $this->repo->insertData($table, $data);

        return response()->json([
            'status'  => true,
            'message' => 'Data Added Successfully'
        ]);
    }


    public function update($request, $validation_rules, $model, $id, $image_paths = [])
    {
        $validated = $request->validate($validation_rules);

        $data = $validated;

        // Handle images dynamically
        foreach ($image_paths as $field => $path) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($path, 'public');
            }
        }

        $data['updated_at'] = now();

        return $model::where('id', $id)->update($data);
    }

    public function delete($model, $id, $image_fields = [])
    {
        // Fetch item
        $item = $model::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        // Delete images if exist
        foreach ($image_fields as $field) {
            if (!empty($item->$field)) {
                Storage::disk('public')->delete($item->$field);
            }
        }

        // Delete record from database
        $deleted = $item->delete();

        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Data Deleted Successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delete Failed'
        ]);
    }
}
