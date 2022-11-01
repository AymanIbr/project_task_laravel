<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function ShowLogin(Request $request , $guard){
        return response()->view('store.login',compact('guard'));
    }
    public function login(Request $request){

        // $validatore = Validator($request->all(),[
        //     // نخبره اذاموجود في الادمن
        //     'email'=>'required|email|exists:admins,email',
        //     'password'=>'required|string|min:3|max:30',
        //     'remember'=>'required|boolean'
        // ]);
        $validatore = Validator($request->all(),[
            // نخبره اذاموجود في الادمن
            'email'=>'required|email',
            'password'=>'required|string|min:3|max:30',
            'remember'=>'required|boolean',
            'guard'=>'required|string|in:admin,user'
        ],[
            'guard.in'=>'Please , Check Login URL'
        ]);
        if(!$validatore->fails()){
            $credentials = [
                'email'=>$request->get('email'),
                'password'=>$request->get('password')
            ];
            // if(Auth::guard('admin')->attempt($credentials,$request->get('remember'))){
                if(Auth::guard($request->get('guard'))->attempt($credentials,$request->get('remember'))){
                return response()->json([
                    'message'=>'Logged in successfuly'
                ],Response::HTTP_OK);
            }else{
                return response()->json([
                    'message'=>'Login Falied , wrong credentials'
                ],Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json([
                'message'=>$validatore->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

        // public function logout(Request $request){

    //     // Auth::guard('admin')->logout();
    //     auth('admin')->logout();
    //     $request->session()->invalidate();
    //     return redirect()->route('login');
    // }
    public function logout(Request $request){

        // Auth::guard('admin')->logout();

//           هذه الطريقة اذا كان أكثر من اثنين أفضل
    //     if(auth('admin')->check()){
    //         auth('admin')->logout();
    //         $request->session()->invalidate();
    //         return redirect()->route('login','admin');
    //     }else{
    //         auth('user')->logout();
    //         $request->session()->invalidate();
    //         return redirect()->route('login','user');
    //     }
            $guard = auth('admin')->check() ? 'admin':'user';
            auth($guard)->logout();
            $request->session()->invalidate();
            return redirect()->route('login',$guard);
    }

    public function changePassword(){
        return response()->view('store.auth.change_password');
    }
    public function updatePassword(Request $request){
        $guard = auth('admin')->check() ? 'admin':'user';
        $validatore = Validator($request->all(),[
            'current_password'=>"required|string|current_password",
            'new_password'=>'required|string|min:3|confirmed',
            // 'new_password_confirmation'=>
        ]);
        if(!$validatore->fails()){
            $user = auth($guard)->user();
            $user->password = Hash::make($request->get('new_password'));
            $isSaved = $user->save();
            return response()->json([
                'message'=> $isSaved ? 'Password Changed Successfuly':'Failed to Change Passwrod'
            ],$isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'message'=>$validatore->getMessageBag()->first()
                ],Response::HTTP_BAD_REQUEST);
        }
    }
}
