<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function ShowLogin(Request $request){

        // \dd($request->guard);
        $validatorr = Validator(['guard' => $request->guard], [
            'guard' => 'required|string|in:admin,user'
        ]);
        session()->put('guard', $request->guard);
        if (!$validatorr->fails()) {
            return response()->view('store.login');
        } else {
            abort(Response::HTTP_NOT_FOUND, 'The page you have requseted is not found');
        }
    }
    public function login(Request $request){
        $validator = validator([
            'email' => 'required|email',
            'password' => 'required|string|min:3',
            'remember' => 'required|boolean'
        ]);
        $guard = session()->get('guard');
        if (!$validator->fails()) {
            $crednrtials = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            if (Auth::guard($guard)->attempt($crednrtials, $request->input('remember'))) {
                return response()->json(['message' => 'login success'], Response::HTTP_OK);
            } else {
                return response()->json(
                    ['message' => 'Login failed, check login details'],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
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
