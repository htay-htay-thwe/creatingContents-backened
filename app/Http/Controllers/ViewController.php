<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ViewController extends Controller
{
    public function createView($userId,$postIds, Request $request)
    {

        if ($this->checkToken($request)) {
            View::create([
                'postId' => $postIds,
                'userId' => $userId,
            ]);
            $view = View::count();
            return response()->json([
                'view' => $view,
            ]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
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
