<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

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
    //         $user = User::where('email',$request->get('email'))->first();
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
                'revoked'=>true
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
//*********************************************************************************************************** */

//Multi Auth


    // public function login(Request $request){
    //     $validatore = Validator($request->all(), [
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required|string|min:3|max:30',
    //     ]);
    //     if(!$validatore->fails()){

    //     }else{
    //         return response()->json([
    //             'message'=>$validatore->getMessageBag()->first()
    //         ],Response::HTTP_BAD_REQUEST);
    //     }
    // }





    public function logout()
    {
        $token = auth('api')->user()->token();
        $isRevoked = $token->revoke();
        return response()->json([
            'status'=> $isRevoked ,
            'message' => $isRevoked ? 'Logout Successfully' : 'Faild to Logout'
        ], $isRevoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
