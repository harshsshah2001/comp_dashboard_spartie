<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Userlist;
use App\Models\Permission;
use App\Services\AdminService;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function permissions(Request $request)
    {
        $permission = Permission::all();

        // If AJAX request → send JSON for DataTables
        if ($request->ajax()) {
            return response()->json([
                'data' => $permission
            ]);
        }
        return view('admin.Roles and Permissions.permissions');
    }

    public function getPermissions(Request $request)
    {
        $permissions = Permission::select('id', 'name')->get();

        return response()->json([
            'status' => true,
            'data' => $permissions
        ]);
    }

    public function permissionsubmit(Request $request)
    {
        $permission_rules = [
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string',
            'guard_name' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $permission_rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->service->store(
            $request,
            $permission_rules,
            Permission::class
        );
    }
    public function permissiondelete($id)
    {
        $this->service->delete(Permission::class, $id);

        return response()->json([
            'status' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }

    public function permissionedit($id)
    {
        $role = Permission::find($id);
        return response()->json($role);
    }
    public function permissionupdate(Request $request, $id)
    {
        $model = Permission::class;

        $validation_rules = [
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
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
            return response()->json(['status' => true, 'message' => 'Permission Updated Successfully']);
        }

        return response()->json(['status' => false, 'message' => 'Update Failed']);
    }
}
