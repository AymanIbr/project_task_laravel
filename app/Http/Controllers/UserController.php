<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\City;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', auth('user')->id())->with(['roles', 'city'])->get();
        return response()->view('store.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', '=', 'user')->get();
        $cities = City::where('active', '=', true)->get();
        return response()->view('store.users.create', compact('roles', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatore = Validator($request->all(), [
            'name' => 'required|min:3|max:30',
            'active' => 'required|boolean',
            'role_id' => 'required|numeric|exists:roles,id',
            'email' => 'required|email|unique:users',
            'gender' => 'required|string|in:M,F',
            'city_id' => 'required|numeric|exists:cities,id'
        ]);
        if (!$validatore->fails()) {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->active = $request->get('active');
            $user->gender = $request->get('gender');
            $user->city_id = $request->get('city_id');
            $user->password = Hash::make(12345);
            $isSaved = $user->save();
            if ($isSaved) {
                // Notification::sendNow([Admin::all()], new NewUserNotification($user));
                $admin = Admin::first();
                $admin->notify(new NewUserNotification($user));
            }
            if ($isSaved) $user->assignRole(Role::findOrFail($request->input('role_id')));
            return response()->json([
                'message' => $isSaved ? 'User Saved Successfuly' : 'Failed to Save'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
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
    public function edit(User $user)
    {
        $cities = City::where('active','=',true)->get();
        $roles = Role::where('guard_name', '=', 'user')->get();
        $userRoles = $user->roles[0];
        return response()->view('store.users.edit', compact('user', 'roles','cities','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatore = Validator($request->all(), [
            'name' => 'required|min:3|max:30',
            'active' => 'required|boolean',
            'role_id' => 'required|numeric|exists:roles,id',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required|string|in:M,F',
            'city_id' => 'required|numeric|exists:cities,id'
        ]);
        if (!$validatore->fails()) {
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->active = $request->get('active');
            $user->gender = $request->get('gender');
            $user->city_id = $request->get('city_id');
            $isSaved = $user->save();
            if ($isSaved) $user->syncRoles(Role::findOrFail($request->input('role_id')));
            return response()->json([
                'message' => $isSaved ? 'User Saved Successfuly' : 'Failed to Save'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        if($isDeleted){
            return response()->json([
                'title'=>'Success','text'=>'User Deleted Successfully','icon'=>'success'
            ],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>'Failed','text'=>'User Deleted Failed','icon'=>'error'
        ],Response::HTTP_BAD_REQUEST);
        }
    }
}
