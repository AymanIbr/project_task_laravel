<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiAuthController extends Controller
{


    //***************************************************************************************************************** */
    //Singel Personal authintication
    // يشتغل على اي جهاز بنفس الوقت
    // public function login(Request $request){

    //     $validatore = Validator($request->all(),[
    //         'email'=>'required|email|exists:users,email',
    //         'password'=>'required|string|min:3|max:30',
    //     ]);
    //     if(!$validatore->fails()){
    //هنا نجيب بيانات اليوزر
    //         $user = User::where('email',$request->get('email'))->first();
    //          تحقق من كلمة المرور
    //         if(Hash::check($request->get('password'),$user->password)){
    //         $token = $user->createToken('user-Api');
    //         $user->setAttribute('token',$token->accessToken);
    //             return response()->json([
    //                 'message'=>'logged in Successfuly','data'=>$user
    //             ],Response::HTTP_OK);
    //         }else{
    //             return response()->json(['message'=>'Wrong Password'],Response::HTTP_OK);
    //         }
    //     }else{
    //         return response()->json([
    //             'message'=>$validatore->getMessageBag()->first()
    //         ],Response::HTTP_BAD_REQUEST);
    //     }
    // }


    /*------------------------------------------------------------------------*/
    // يطفي باقي الاجهزة اذا تم تسجيل login بنفس الوقت
    public function login(Request $request)
    {
        $validatore = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:3|max:30',
        ]);
        if (!$validatore->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $user->password)) {
                $this->revokePreviousTokens($user->id);
                $token = $user->createToken('user-Api');
                $user->setAttribute('token', $token->accessToken);
                return response()->json([
                    'message' => 'logged in Successfuly', 'data' => $user
                ], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Wrong Password'], Response::HTTP_OK);
            }
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function revokePreviousTokens($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->update([
                'revoked' => true
            ]);
    }

    /*------------------------------------------------------------------------*/

    // ممنوع عمل تسجيل دخول اذا كان في حد عامل تسجيل دخول

    // public function login(Request $request)
    //     {
    //         $validatore = Validator($request->all(), [
    //             'email' => 'required|email|exists:users,email',
    //             'password' => 'required|string|min:3|max:30',
    //         ]);
    //         if (!$validatore->fails()) {
    //             $user = User::where('email', $request->get('email'))->first();
    //             if (Hash::check($request->get('password'), $user->password)) {
    //                 if(!$this->checkForActiveTokens($user->Id)){
    //                     $token = $user->createToken('user-Api');
    //                     $user->setAttribute('token', $token->accessToken);
    //                     return response()->json([
    //                         'message' => 'logged in Successfuly', 'data' => $user
    //                     ], Response::HTTP_OK);
    //                 }else{
    //                     return response()->json(['message' => 'Unable to login from two devices at the same time'], Response::HTTP_OK);
    //                 }
    //             } else {
    //                 return response()->json(['message' => 'Wrong Password'], Response::HTTP_OK);
    //             }
    //         } else {
    //             return response()->json([
    //                 'message' => $validatore->getMessageBag()->first()
    //             ], Response::HTTP_BAD_REQUEST);
    //         }
    //     }
    //     private function checkForActiveTokens($userId){
    //       return  DB::table('oauth_access_tokens')
    //         ->where('user_id',$userId)
    //         ->where('revoked',false)
    //         ->exists();
    //     }

    /*------------------------------------------------------------------------*/
    public function logout()
    {
        $token = auth('api')->user()->token();
        $isRevoked = $token->revoke();
        return response()->json([
            'status' => $isRevoked,
            'message' => $isRevoked ? 'Logout Successfully' : 'Faild to Logout'
        ], $isRevoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    //*********************************************************************************************************** */

    //Multi Auth


    public function logidn(Request $request)
    {
        $validatore = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:3|max:30',
        ]);



        if (!$validatore->fails()) {
            try {
                $response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '1',
                    'client_secret' => 'xu6wnACCzmSAUVxYEG0sv2vceFlTEwGY9F6PV8ri',
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => '*'
                ]);
                $user = User::where('email', $request->get('email'))->first();
                $user->setAttribute('token', $response->json()['access_token']);
                $user->setAttribute('token_type', $response->json()['token_type']);
                $user->setAttribute('refresh_token', $response->json()['refresh_token']);
                return response()->json([
                    'message' => 'Logged in successfully', 'data' => $user,
                ], Response::HTTP_OK);
            } catch (Exception $e) {
                if ($response->json()['error'] == 'invalid_grant') {
                    return response()->json([
                        'status' => \false,
                        'message' => 'Wrong credentials, please enter correct email and password'
                    ], Response::HTTP_BAD_REQUEST);
                }
                return response()->json([
                    'status' => \false,
                    'message' => 'Login faild , please try again'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validatore->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function foregetPassword(Request $request)
    {

        $validatore = Validator($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        if (!$validatore->fails()) {
            $reandomInt = random_int(10000, 9999);
            $user = User::where('email', '=', $request->input('email'))->first();
            $user->verification_code = Hash::make($reandomInt);
            $isSaved = $user->save();
            return response()->json(
                ['message' => $isSaved ? 'Password reset code sent successfully' : 'Failed to sent password reset code!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validatore->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function resetPassword(Request $request)
    {

        $validatore = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:4',
            'password' => 'required|string|confirmed'
        ]);
        if (!$validatore->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (!is_null($user->verification_code)) {
                if (Hash::check($request->input('code'), $user->verification_code)) {
                    $user->verification_code == null;
                    $user->password = Hash::make($request->input('password'));
                    $isSaved = $user->save();
                    return response()->json(
                        ['message' => $isSaved ? 'Reset password success' : 'Failed to reset password!'],
                        $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                    );
                } else {
                    return response()->json(
                        ['message' =>  'Password reset code error, try again'],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    ['message' =>  'No forget password request exist,process denied!'],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['message' => $validatore->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function changePassword(Request $request)
    {
        $validatore = Validator($request->all(), [
            // 'password' => 'required|password:user-api'
            'password' => 'required|current_password:api',
            'new_password' => 'required|confirmed',
        ]);
        if (!$validatore->fails()) {
            $user = $request->user();
            $user->password = Hash::make($request->input('new_password'));
            $isSaved = $user->save();
            return response()->json(
                [
                    'status' => $isSaved,
                    'message' => $isSaved ? 'change password successfully' : 'Failed to change password!'
                ],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validatore->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
