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
use App\Models\Role;
use App\Http\Controllers\helper\CustomResponse;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => "Validation errors",
                    'success' => false,
                    'statusCode' => 400,
                    'data' => $validator->errors()
                ],
                400
            );
        }
        Log::info('Checking if user with email: ' . $input['email'] . ' exist');
        $duplicateUser = DB::table('users')
            ->where('email', '=', $input['email'])
            ->first();

        if ($duplicateUser) {
            Log::alert(' user with email: ' . $input['email'] . ' already exist');
            return response()->json([
                'message' => 'This user already exists',
                'success' => false,
                'statusCode' => 422,
                'data' => null
            ], 422);
        }

        $userole = Role::where('name', 'USER')->first();
        Log::info('Role found is :::: ' . $userole . ' Proceeding to create user ' . $input['email']);
        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'msisdn' => $input['msisdn'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        $user->assignRole($userole);
        return response()->json([
            'message' => 'User Created succesfully',
            'success' => true,
            'statusCode' => 201,
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                "success" => false,
                "statusCode" => 400,
                "data" => $validator->errors()
            ], 400);
        }
        $user = User::where('email', $request['email'])->first();
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json(
                new CustomResponse("The provided credentials are incorrect.", false, 401, null),
                401
            );
        }
        $array[] = $user->permissions()->map(function ($obj) {
            return $obj;
        });
        foreach ($array as $value) {
            Log::info('permission granted to user ' . $value);
        }
        $expirationTime = Carbon::now()->addDays(7);
        $expirationInSeconds = Carbon::parse($expirationTime)->diffInSeconds(Carbon::now());
        $token = $user->createToken(
            $request['email'],
            [
                'permissions' => $array,
                'expires' => $expirationTime
            ]
        )->plainTextToken;

        $response =
            [
                'grant_type' => 'password',
                'token' => $token,
                'username' => $user->email,
                'expires' =>  $expirationInSeconds,
                //'role' => $user->roles
            ];

        return response()->json(
            new CustomResponse("Token fetched successfully", true, 200, $response),
            200
        );
    }

    public function logout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                new CustomResponse("The provided credentials are incorrect.", false, 401, null),
                401
            );
        }
        Log::info($user->name . ' logging out...');
        $revoke = $user->tokens()->delete();
        if ($revoke) {
            Log::info($user->name . ' logged out succesfully');
            return response()->json(
                new CustomResponse("Logged out successfully", true, 200, null),
                200
            );
        } else {
            Log::error('message');
            ($user->name . ' failed to log out');
            return response()->json(
                new CustomResponse("Log out failed", false, 500, null),
                500
            );
        }
    }
}
