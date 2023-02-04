<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return response()->view('store.auth.forgot_password');
    }

    public function sendReetLink(Request $request)
    {
        $validatore = Validator($request->all(), [
            'email' => 'required|email'
        ]);

        if (!$validatore->fails()) {
            // status ترجع قسمة رسالة من ملف الباسوورد
            $status = Password::sendResetLink(['email' => $request->input('email')]);
            // === تعني المساواة في القيمة والنوع
            return response()->json(
                ['message' => __($status)],
                $status === Password::RESET_LINK_SENT
                    ? Response::HTTP_OK
                    : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function showResetPassword(Request $request, $token)
    {

        return response()->view('store.auth.reset_password', ['token' => $token, 'email' => $request->input('email')]);
    }
    public function resetPassword(Request $request)
    {
        $validatore = Validator($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|confirmed'
        ]);

        if (!$validatore->fails()) {
            $status = Password::reset($request->only(
                'email',
                'token',
                'password',
                'password_confirmation'
            ), function ($user, $password) {
                // $user->forceFill([
                //     $user->password = Hash::make($password),
                // ]);
                $user->password = Hash::make($password);
                $user->save();
            });
            return response()->json(
                ['message' => __($status)],
                $status === Password::PASSWORD_RESET
                    ? Response::HTTP_OK
                    : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
        //لو اردنا تغير المدة الزمنية نغيرها من ال auth
    }
}
