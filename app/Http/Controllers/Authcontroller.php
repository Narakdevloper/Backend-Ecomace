<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
public function register(Request $request){
    $fields=$request->validate([
'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
    ]);
$user=User::create([
    'name'=>$fields['name'],

    'email'=>$fields['email'],
    'password'=>Hash::make($fields['password'])
]);
$token = $user->createToken('myapptoken')->plainTextToken;
return response()->json([
    'status'=>true,
    'message'=>'Register succesfully',
    'user'=>$user,
    'token'=>$token
],201);
}
public function login(Request $request) {
$fields=$request->validate([
    'email'=>'required|string|email',
       'password'=>'required|string',
]);
$user=User::where('email',$fields['email'])->first();
if(!$user||!Hash::check($fields['password'],$user->password))
return response()->json([
        'status'=>false,
    'message'=>'incorrect password or name',
],401);
$token=$user->createToken('myapptoken')->plainTextToken;
return response()->json([
        'status'=>true,
    'message'=>'login succesfully',
        'user'=>$user,
    'token'=>$token
],200);

}
public function logout(Request $request){
$request->user()->currentAccessToken()->delete();
return response()->json([
            'status'=>true,
    'message'=>'logout succesfully',
],200);
    
}
public function resetPassword(Request $request){
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($request->password !== $request->password_confirmation) {
        return response()->json([
            'status' => false,
            'message' => 'Password and confirmation do not match.',
        ], 400);
    }
    $user=User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();
    return response()->json([
        'status' => true,
        'message' => 'Password reset successfully.',
    ], 200);
    
}
}
