<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LikeController extends Controller
{
    public function addLike($postId, $userId,Request $request)
    {
        if ($this->checkToken($request)) {
        $like = Like::where('post_id', $postId)->where('userId', $userId)->first();
        if ($like === null) {
            Like::create([
                'post_id' => $postId,
                'userId' => $userId,
            ]);

        } else if ($like->like !== 0) {
            Like::where('post_id', $postId)->where('userId', $userId)->
                update([
                'like' => false,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
    }

    public function unlike($postId, $userId, Request $request)
    {
        if ($this->checkToken($request)) {
            $like = Like::where('post_id', $postId)->where('userId', $userId)->first();

            if ($like === null) {
                Like::create([
                    'post_id' => $postId,
                    'userId' => $userId,
                    'like' => true,
                ]);
            } else {
                Like::where('post_id', $postId)->where('userId', $userId)
                    ->update([
                        'like' => true,
                    ]);
            }
        }

        return response()->json([
            'success' => true,
        ]);
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
