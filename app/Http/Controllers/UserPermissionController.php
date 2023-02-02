<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {


        $permissions = Permission::where('guard_name','=', 'user')->get();
        $userPermissions = $user->permissions()->get();
        if(count($userPermissions) > 0){
            foreach($permissions as $permission){
                $permission->setAttribute('assigned', false);
                foreach($userPermissions as $userPermission){
                    if($permission->id == $userPermission->id){
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return view('store.users.user-perissions', compact('user','permissions','userPermissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , User $user)
    {
        $validator = Validator( $request->all(),[
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);

        if(!$validator->fails()){
            $permission = Permission::findOrFail($request->get('permission_id'));
            if($user->hasPermissionTo($permission)){
                $user->revokePermissionTo($permission);
            }else{
                $user->givePermissionTo($permission);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
