<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CommentController extends Controller
{
    public function showComments($postId,Request $request)
    {
        if($this->checkToken($request)){
      $comment = $this->getAllComments($postId);
        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }
    }

    // create comments
    public function createComments($postId, $parentId,$userId, $comment,Request $request)
    {
        if($this->checkToken($request)){
        Comment::create([
            'userId' => $userId,
            'post_id' => $postId,
            'parent_id' => $parentId,
            'comment' => $comment,
        ]);

        $comment = $this->getAllComments((string) $postId);
        logger($comment);
        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }
    }

    public function reply($postId,$userId,Request $request){
        if($this->checkToken($request)){
            logger($postId);
            logger($userId);
            logger($request->all());
            Comment::create([
                'userId' => $userId,
                'post_id' => $postId,
                'parent_id' => $request->parentId, // Assuming parentId is sent in the request
            'comment' => $request->reply,
            ]);
            $comment = $this->getAllComments($postId);
            return response()->json([
                'success' => true,
                'comment' => $comment,
            ]);
        }
    }

    private function getAllComments($postId)
    {
        $comment = Post::with([
            'user:id,name,image',
            'comments' => function ($query) use ($postId)  {
                $query->where('post_id', $postId)->where('parent_id','1'); // Ensure comments are for post ID 9
            },
            'comments.user:id,name,image', // Load user for comments
            'comments.replies' => function ($query) use ($postId)  {
                $query->where('post_id', $postId); // Ensure replies are for post ID 9
            },
            'comments.replies.user:id,name,image', // Load user for replies
            'comments.replies.replies' => function ($query) use ($postId)  {
                $query->where('post_id', $postId); // Ensure nested replies are for post ID 9
            },
            'comments.replies.replies.user:id,name,image', // Load user for nested replies
            'comments.replies.replies.replies' => function ($query) use ($postId)  {
                $query->where('post_id', $postId); // Ensure nested replies are for post ID 9
            },
            'comments.replies.replies.replies.user:id,name,image', // Load user for nested replies
            'comments.replies.replies.replies.replies' => function ($query) use ($postId) {
                $query->where('post_id', $postId); // Ensure nested replies are for post ID 9
            },
            'comments.replies.replies.replies.replies.user:id,name,image', // Load user for nested replies
        ])->where('id', $postId)->first();
        return $comment;

    }


    private function checkToken($request)
    {
        $token = $request->bearerToken();
        try {
            $user = JWTAuth::checkOrFail($token);
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
