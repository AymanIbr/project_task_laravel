<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {

        // لو اردت ان اظهر كل البيرمشن تاعت اليوزر والادمن
        // $permissions = Permission::all();

        $permissions = Permission::where('guard_name','=', $role->guard_name)->get();
        $rolePermissions = $role->permissions;
        if (count($rolePermissions) > 0) {
            foreach ($permissions as $permission) {
                $permission->setAttribute('assigned', false);
                foreach ($rolePermissions as $rolePermission) {
                    if ($permission->id == $rolePermission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return view('store.spatie.roles.role-permission', compact('role', 'permissions', 'rolePermissions'));
    }

    public function store(Request $request,Role $role)
    {
        $validator = Validator( $request->all(),[
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);

        if (!$validator->fails()) {
            // $role= Role::findOrFail($request->input('role_id'));
            $permission = Permission::findOrFail($request->get('permission_id'));
            if($role->hasPermissionTo($permission)){
                $role->revokePermissionTo($permission);
            }else{
                $role->givePermissionTo($permission);
                }
            return response()->json([
                'message'=>'Permission Updated Successfuly'
            ],Response::HTTP_OK);
        }else {
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

}
