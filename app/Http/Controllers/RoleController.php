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
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        Role::create([
            'name'        => $request->name,
            'description' => $request->description,
            'guard_name'  => 'userlist', // ✅ REQUIRED
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Role created successfully',
        ]);
    }


    public function edit($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $id,
        'description' => 'nullable|string',
    ]);

    $role = Role::findOrFail($id);

    $role->update([
        'name'        => $request->name,
        'description' => $request->description,
        'guard_name'  => 'userlist', // ✅ FORCE
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Role Updated Successfully'
    ]);
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
