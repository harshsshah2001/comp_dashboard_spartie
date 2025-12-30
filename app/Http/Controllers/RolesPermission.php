<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Userlist;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class RolesPermission extends Controller
{

    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }


    // Role functions is start here

    // public function roles(Request $request)
    // {

    //     $roles = Role::all();

    //     // If AJAX request → send JSON for DataTables
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'data' => $roles
    //         ]);
    //     }
    //     return view('admin.Roles and Permissions.role-list');
    // }

    // public function rolesubmit(Request $request)
    // {
    //     $role_rules = [
    //         'rolename' => 'required|string|max:255|unique:roles,rolename',
    //         'description' => 'nullable|string',
    //     ];

    //     $validator = Validator::make($request->all(), $role_rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     return $this->service->store(
    //         $request,
    //         $role_rules,
    //         \App\Models\Role::class
    //     );
    // }

    // public function edit($id)
    // {
    //     $role = Role::find($id);
    //     return response()->json($role);
    // }

    // public function update(Request $request, $id)
    // {
    //     $model = \App\Models\Role::class;

    //     $validation_rules = [
    //         'rolename' => 'required|string|max:255|unique:roles,rolename,' . $id,
    //         'description' => 'nullable|string',
    //     ];

    //     $validator = Validator::make($request->all(), $validation_rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Validation failed',
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     $updated = $this->service->update($request, $validation_rules, $model, $id);

    //     if ($updated) {
    //         return response()->json(['status' => true, 'message' => 'Role Updated Successfully']);
    //     }

    //     return response()->json(['status' => false, 'message' => 'Update Failed']);
    // }

    // public function roledelete($id)
    // {
    //     $this->service->delete(\App\Models\Role::class, $id);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Role deleted successfully'
    //     ]);
    // }

    // public function rolelist(Request $request)
    // {

    //     $roles = Role::all();

    //     // If AJAX request → send JSON for DataTables
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'data' => $roles
    //         ]);
    //     }
    //     return view('admin.Roles and Permissions.role-list');
    // }


    // public function permissions(Request $request)
    // {
    //     $permission = Permission::all();

    //     // If AJAX request → send JSON for DataTables
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'data' => $permission
    //         ]);
    //     }
    //     return view('admin.Roles and Permissions.permissions');
    // }



    // public function getPermissions(Request $request)
    // {
    //     $permissions = Permission::select('id', 'permission_name')->get();

    //     return response()->json([
    //         'status' => true,
    //         'data' => $permissions
    //     ]);
    // }




    // public function permissionsubmit(Request $request)
    // {
    //     $permission_rules = [
    //         'permission_name' => 'required|string|max:255|unique:roles,rolename',
    //         'description' => 'nullable|string',
    //     ];

    //     $validator = Validator::make($request->all(), $permission_rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     return $this->service->store(
    //         $request,
    //         $permission_rules,
    //         \App\Models\Permission::class
    //     );
    // }
    // public function permissiondelete($id)
    // {
    //     $this->service->delete(\App\Models\Permission::class, $id);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Permission deleted successfully'
    //     ]);
    // }

    // public function permissionedit($id)
    // {
    //     $role = Permission::find($id);
    //     return response()->json($role);
    // }
    // public function permissionupdate(Request $request, $id)
    // {
    //     $model = \App\Models\Permission::class;

    //     $validation_rules = [
    //         'permission_name' => 'required|string|max:255|unique:permissions,permission_name,' . $id,
    //         'description' => 'nullable|string',
    //     ];

    //     $validator = Validator::make($request->all(), $validation_rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Validation failed',
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     $updated = $this->service->update($request, $validation_rules, $model, $id);

    //     if ($updated) {
    //         return response()->json(['status' => true, 'message' => 'Permission Updated Successfully']);
    //     }

    //     return response()->json(['status' => false, 'message' => 'Update Failed']);
    // }


    public function role_permission_list()
    {
        return view('admin.Roles and Permissions.role-permission-list');
    }

    public function user_list(Request $request)
    {
        // if ($request->ajax()) {

        //     // Get all users
        //     $users = Userlist::all();

        //     // Get all roles and convert to key-value pair
        //     // [ id => rolename ]
        //     $roles = Role::pluck('rolename', 'id');

        //     // Attach role name manually
        //     $users = $users->map(function ($user) use ($roles) {
        //         return [
        //             'id'    => $user->id,
        //             'name'  => $user->name,
        //             'email' => $user->email,
        //             'role'  => $roles[$user->role_id] ?? '-',
        //         ];
        //     });

        //     return response()->json([
        //         'data' => $users
        //     ]);
        // }

        // // Page load
        // $role = Role::all();
        return view('admin.Roles and Permissions.user-list');
    }

    public function usersubmit(Request $request)
    {
        $user_rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:userlists,email',
            'number'    => 'required|string|max:20|unique:userlists,number',
            'password'  => 'required|string|min:6',
            'role_id'   => 'nullable',
        ];

        $validator = Validator::make($request->all(), $user_rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 🔐 HASH PASSWORD
        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        return $this->service->store(
            $request,
            $user_rules,
            \App\Models\Userlist::class
        );
    }

    public function userdelete(Request $request)
    {
        $this->service->delete(Userlist::class, $request->id);

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    // public function assignPermissions(Request $request)
    // {
    //     $request->validate([
    //         'role_id' => 'required',
    //         'permissions' => 'array'
    //     ]);

    //     $roleId = $request->role_id;
    //     $permissions = $request->permissions ?? [];

    //     // 🔥 Delete old permissions for this role/user
    //     UserPermission::where('user_id', $roleId)->delete();

    //     // 🔥 Insert new permissions
    //     $data = [];
    //     foreach ($permissions as $permissionId) {
    //         $data[] = [
    //             'user_id' => $roleId,          // storing role_id as user_id (as per your design)
    //             'permission_id' => $permissionId,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     if (!empty($data)) {
    //         UserPermission::insert($data);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Permissions assigned successfully'
    //     ]);
    // }
}
