<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $input){
           $validator=Validator::make($input->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation errors",
                'statusCode' => 400,
                'errors'=>$validator->errors()], 400
            );
        }
          Log::info('Checking if user with email: '.$input['email'].' exist');
           $duplicateUser = DB::table('users')
           ->where('email', '=', $input['email'])
           ->first();

           if ($duplicateUser) {
               Log::alert(' user with email: '.$input['email'].' already exist');
               return response()->json([
                'message'=>'This user already exists',
                'statusCode'=>422,
                'data' => null
            ], 422);
           }
          Log::info('Creating user '.$input['email'] );
           $user= User::create([
               'first_name' => $input['first_name'],
               'last_name' => $input['last_name'],
               'msisdn' => $input['msisdn'],
               'email' => $input['email'],
               'password' => Hash::make($input['password']),
           ]);
           return response()->json([
            'message' => 'User Created succesfully',
            'statusCode' => 201,
            'data' => $user
        ], 201);
       }

       public function login(Request $request){
        $validator=Validator::make($request->all(),[
           'email' => 'required|email',
           'password' => 'required',
           'name' => 'required',
       ]);
       if($validator->fails()){
           return response()->json($validator->errors(),400);
       }
       //$http = new Client(['verify' => false]);

       $user = User::where('email', $request->data['attributes']['email'])->first();
       if (! $user || ! Hash::check($request->data['attributes']['password'], $user->password)) {
              return response()->json(['message'=>'The provided credentials are incorrect.'], 401);
       }
           $array[] = $user->permissions()->map( function ($obj) {
           return $obj;
           });
           foreach($array as $value){
             Log::info('permission granted to user '.$value);
            }

       $token=$user->createToken($request->data['attributes']['name'], $array)->plainTextToken;
       //return response()->json(['token'=>$token],200);

       $response = [
                   'form_params' => [
                       'grant_type' => 'password',
                       'client_id' => $token,
                       'client_secret' => $token,
                       'username' => $user->email,
                       'password' => $user->password,
                       'scope' => '',
                   ],
               ];

               return response()->json($response,200);
       }

       public function logout(Request $request){
        $request->validate([
           'email' => 'required|email',
           'password' => 'required',
           'device_name' => 'required',
       ]);

       $user = User::where('email', $request->email)->first();

       if (! $user || ! Hash::check($request->password, $user->password)) {
              return response()->json(['message'=>'The provided credentials are incorrect.']);

       }
       Log::info($user->name.' logging out...');
       $revoke=$user->tokens()->delete();
       if($revoke){
           Log::info($user->name.' logged out succesfully');
          return response()->json(['message'=>'Logged out successfully'],200);
       }else{
           Log::error('message');($user->name.' failed to log out');
          return response()->json(['message'=>'Logged out failed'],500);
       }
       }
}
