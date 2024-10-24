<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SaveController extends Controller
{

    public function Save($postId, $userId, Request $request)
    {
        if ($this->checkToken($request)) {
            Save::create([
                'post_id' => $postId,
                'userId' => $userId,
            ]);

            return response()->json([
                'success' => true,
            ]);
        }
    }

    public function unSave($postId, Request $request)
    {
        if ($this->checkToken($request)) {
            Save::where('post_id', $postId)->delete();

            return response()->json([
                'success' => true,
            ]);

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
