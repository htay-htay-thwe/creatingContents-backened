<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'Account with this email already exists!'], 409); // 409 Conflict
        } else {
            $data = User::create([
                'name' => $request->userName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user = User::where('email', $request->email)->first();

            $token = JWTAuth::fromUser($data);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        // Extract email and password from the request
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Account not found'], 404);
        }
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function uploadProfile(Request $request)
    {
        if ($this->checkToken($request)) {
            $image = $request->file('image');
            $fileName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $fileName);
            User::where('id', $request->userId)->update([
                'image' => $fileName,
            ]);
            $user = User::where('id', $request->userId)->first();
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }
    }

    public function updateInfo(Request $request)
    {
        if ($this->checkToken($request)) {
            if (User::where('email', $request->email)
                ->where('id', '!=', $request->userId) // Exclude the current user
                ->exists()) {
                return response()->json(['error' => 'Account with this email already exists!'], 409); // 409 Conflict
            } else {
                User::where('id', $request->userId)->update([
                    'name' => $request->userName,
                    'email' => $request->email,
                ]);
            }
        }

        $user = User::where('id', $request->userId)->first();
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function changePw(Request $request)
    {
        if ($this->checkToken($request)) {
            $data = User::where('id', $request->userId)->first();
            if (Hash::check($request->oldPassword, $data->password)) {
                User::where('id', $request->userId)->update([
                    'password' => Hash::make($request->password),
                ]);
                $user = User::where('id', $request->userId)->first();
                return response()->json([
                    'success' => true,
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Old password is incorrect.',
                ], 400);
            }
        }
    }

    private function checkToken($request)
    {
        $token = $request->bearerToken(); // Get the token from the Authorization header

        try {
            $user = JWTAuth::checkOrFail($token);
            // Token is valid, return user information
            return response()->json(['user' => $user], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not provided'], 400);
        }
    }
}
