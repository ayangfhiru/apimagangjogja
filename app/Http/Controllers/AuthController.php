<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'string|max:255',
                'email' => 'required|string|email:dns|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'device_name' => 'required|string',
            ]);

            $user = User::create([
                'name' => $validate['name'],
                'password' => bcrypt($validate['password']),
                'email' => $validate['email'],
                'profile_photo_path' => 'default_avatar.png',
            ]);

            $token = $user->createToken($validate['device_name'])->plainTextToken;
            $email = $request['email'];
            $password = $request['password'];

            Auth::attempt(['email' => $email, 'password' => $password], true);

            return response()->json([
                'success' => true,
                'data' => $token,
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'success' => 'Register error',
                'error' =>  $err
            ]);
        }
    }

    public function Login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email:dns',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken($request->device_name)->plainTextToken;
            return response()->json([
                'success' => true,
                'data' => $token
            ]);
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'error' => $err
            ]);
        }
    }
}
