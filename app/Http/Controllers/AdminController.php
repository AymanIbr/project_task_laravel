<?php

namespace App\Http\Controllers;

use App\Mail\AdminWelcomeEmail;
use App\Models\Admin;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Str;


class AdminController extends Controller
{

    // في هذه الحالة كل الدوال تم تسكيرها
    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::with('roles')->get();
        return response()->view('store.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', '=', 'admin')->get();
        return response()->view('store.admins.create', compact('roles'));
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
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|min:3|max:30',
            'active' => 'required|boolean',
            'email' => 'required|email|unique:admins,email',
        ]);
        if (!$validatore->fails()) {
            $admin = new Admin();
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->active = $request->get('active');
            // $admin->password = Hash::make(12345);
            $reandomString = Str::random(10);
            $admin->password = Hash::make($reandomString);
            $isSaved = $admin->save();
            if ($isSaved){
                $admin->assignRole(Role::findOrFail($request->input('role_id')));
                // Mail::to($admin)->send(new AdminWelcomeEmail($admin,$reandomString));
                // ولكن الافضل ان اقوم بوضعها في المودل
                // Mail::to($admin)->queue(new AdminWelcomeEmail($admin,$reandomString));
                //ممكن ايضا ان نعمل تاخير مثلا بعد خمس ثوان
                // Mail::to($admin)->later(5,new AdminWelcomeEmail($admin,$reandomString));
                //ممكن ان اضيفها بكيو لحال
                $message = (new AdminWelcomeEmail($admin,$reandomString))->onQueue('Emails');
                Mail::to($admin)->queue($message);
                // Mail::to($admin)->later(5,$message);

            }
            return response()->json([
                'message' => $isSaved ?  'Saved Successfuly' : 'Failed to Save'
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', '=', 'admin')->get();
        $adminRole = $admin->roles[0];
        return response()->view('store.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validatore = Validator($request->all(), [
            'name' => 'required|min:3|max:30',
            'active' => 'required|boolean',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);
        if (!$validatore->fails()) {
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->active = $request->get('active');
            $isUpdate = $admin->save();
            if ($isUpdate) $admin->syncRoles(Role::findOrFail($request->input('role_id')));
            return response()->json([
                'message' => $isUpdate ? 'Updated Successfuly' : 'Failed to Update'
            ], $isUpdate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() != $admin->id) {
            $isDeleted = $admin->delete();
        } else {
            return response()->json([
                'text' =>  'Deleted Failed , Can\'t delete Your Acount !'
            ], Response::HTTP_BAD_REQUEST);
        }
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Admin Deleted Successfully', 'icon' => 'success'], Response::HTTP_OK);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Admin Deleted Failed', 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
        }
    }
}
