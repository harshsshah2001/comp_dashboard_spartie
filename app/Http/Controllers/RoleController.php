<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AdminService;
use App\Models\Role;

class RoleController extends Controller
{
      protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function roles(Request $request)
    {

        $roles = Role::all();

        // If AJAX request → send JSON for DataTables
        if ($request->ajax()) {
            return response()->json([
                'data' => $roles
            ]);
        }
        return view('admin.Roles and Permissions.role-list');
    }

    public function rolesubmit(Request $request)
    {
        $role_rules = [
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $role_rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->service->store(
            $request,
            $role_rules,
            \App\Models\Role::class
        );
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $model = \App\Models\Role::class;

        $validation_rules = [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $updated = $this->service->update($request, $validation_rules, $model, $id);

        if ($updated) {
            return response()->json(['status' => true, 'message' => 'Role Updated Successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Update Failed']);
    }

    public function roledelete($id)
    {
        $this->service->delete(\App\Models\Role::class, $id);

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

    public function rolelist(Request $request)
    {

        $roles = Role::all();

        // If AJAX request → send JSON for DataTables
        if ($request->ajax()) {
            return response()->json([
                'data' => $roles
            ]);
        }
        return view('admin.Roles and Permissions.role-list');
    }

}
