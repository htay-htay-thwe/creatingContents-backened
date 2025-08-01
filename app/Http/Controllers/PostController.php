<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    public function postCreate(Request $request)
    {
        $post = Post::create([
            'userId'  => $request->userId,
            'genre'   => $request->genre,
            'title'   => $request->title,
            'content' => $request->content,

        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = uniqid() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $fileName);
                $post->images()->create(['path' => $fileName]);
            }
        }
        $userId   = 1;
        $data     = $this->getCommonData($userId);
        $postAuth = $data->where('userId', $request->userId)->values();

        return response()->json([
            'success'  => true,
            'post'     => $data,
            'postAuth' => $postAuth,
        ]);

    }

    public function search($userId, $searchKey, Request $request)
    {
        if ($this->checkToken($request)) {
            $data = $this->getCommonData($userId);

            $searchResults = $data->filter(function ($item) use ($searchKey) {
                return (
                    stripos($item['writerProfile'] ?? '', $searchKey) !== false ||
                    stripos($item['genre'] ?? '', $searchKey) !== false ||
                    stripos($item['title'] ?? '', $searchKey) !== false ||
                    stripos($item['content'] ?? '', $searchKey) !== false
                );
            });
            $searchResults = $searchResults->values();
            return response()->json([
                'success' => true,
                'search'  => $searchResults,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function genreSearch($userId, $genre, Request $request)
    {
        if ($this->checkToken($request)) {
            $data          = $this->getCommonData($userId);
            $searchResults = $data->filter(function ($item) use ($genre) {
                return (
                    stripos($item['genre'] ?? '', $genre) !== false
                );
            });
            $searchResults = $searchResults->values();
            return response()->json([
                'success' => true,
                'search'  => $searchResults,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function getProfilePost($userId, Request $request)
    {
        logger('hi');
        if ($this->checkToken($request)) {
            $data         = $this->getCommonData($userId);
            $postAuth     = $data->where('userId', $userId)->values();
            $deleted      = $this->getArchiveData($userId);
            $deletedPosts = $deleted->where('userId', $userId)->values();
            $view         = View::count();
            $save         = $data->where('save', 0)->whereNotNull('save')->where('AuthId', $userId)->values();
            logger('true');
            return response()->json([
                'success'      => true,
                'post'         => $data,
                'postAuth'     => $postAuth,
                'deletedPosts' => $deletedPosts,
                'view'         => $view,
                'save'         => $save,
            ]);
        } else {
            logger('token invalid');
        }

    }

    public function editPost($postId, $userId, Request $request)
    {

        if ($this->checkToken($request)) {

            $data = $this->getCommonData($userId);
            $post = $data->where('id', $postId)->first();
            return response()->json([
                'success' => true,
                'post'    => $post,

            ]);
        }

    }

    public function updatePost(Request $request)
    {
        if ($this->checkToken($request)) {
            $post = Post::findOrFail($request->postId);
            $post->update([
                'userId'  => $request->userId,
                'genre'   => $request->genre,
                'title'   => $request->title,
                'content' => $request->content,
            ]);
            if ($request->hasFile('images') || $request->has('imageUrls')) {
                $newImagePaths = [];

                // Handle image URLs if provided (optional)
                if ($request->has('imageUrls')) {
                    foreach ($request->imageUrls as $imageUrl) {
                        $fileName        = str_replace('http://localhost:8000/storage/images/', '', $imageUrl);
                        $newImagePaths[] = $fileName;
                    }
                }

                // Handle newly uploaded files if provided
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $fileName = uniqid() . '_' . $image->getClientOriginalName();
                        $image->storeAs('public/images', $fileName);
                        $newImagePaths[] = $fileName;
                    }
                }

                foreach ($post->images as $oldImage) {
                    if (! in_array($oldImage->path, $newImagePaths)) {
                        $oldImagePath = 'public/images/' . $oldImage->path;
                        if (Storage::exists($oldImagePath)) {
                            Storage::delete($oldImagePath); // Delete image file
                        }
                        $oldImage->delete();
                    }
                }

                foreach ($newImagePaths as $fileName) {
                    if (! $post->images()->where('path', $fileName)->exists()) {
                        $post->images()->create(['path' => $fileName]);
                    }
                }
            }

            $post->update($request->except(['images', 'imageUrls']));

            $userId   = $request->userId;
            $data     = $this->getCommonData($userId);
            $postAuth = $data->where('userId', $request->userId)->values();
            return response()->json([
                'success'  => true,
                'post'     => $data,
                'postAuth' => $postAuth,
            ]);
        }
    }

    public function deletePost($postId, Request $request)
    {
        if ($this->checkToken($request)) {
            Post::where('id', $postId)->delete();
        }
    }

    public function restorePost($postId, Request $request)
    {
        if ($this->checkToken($request)) {
            $post = Post::withTrashed()->find($postId);
            $post->restore();
        }

    }

    public function deletePermanentPost($postId, Request $request)
    {
        if ($this->checkToken($request)) {
            $post = Post::withTrashed()->find($postId);
            $post->forceDelete();
        }

    }

    public function getReadPost($postId, $userId, Request $request)
    {
        if ($this->checkToken($request)) {
            $data = $this->getCommonData($userId);
            $post = $data->where('id', $postId)->first();
            return response()->json([
                'success'  => true,
                'readPost' => $post,
            ]);
        }

    }

    private function getCommonData($userId)
    {
        $data = Post::leftJoin('images', 'posts.id', '=', 'images.post_id')
            ->leftJoin('views', 'posts.id', '=', 'views.postId')
            ->leftJoin('users', 'posts.userId', '=', 'users.id')
            ->leftJoin('saves', function ($join) use ($userId) {
                $join->on('posts.id', '=', 'saves.post_id')
                    ->where('saves.userId', '=', $userId); // Only include saves for userId 1
            })
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('posts.id', '=', 'likes.post_id')
                    ->where('likes.userId', '=', $userId); // Only include saves for userId 1
            })->select('posts.*',
            'posts.id',
            'posts.userId',
            'users.name',
            'users.image as writerProfile',
            'users.email',
            'posts.genre',
            'posts.title',
            'posts.content',
            'images.path',
            'saves.save',
            'saves.userId as AuthId',
            'likes.like',
            'posts.created_at',
            'posts.deleted_at')
            ->get()->groupBy('id')
            ->map(function ($group) {
                $postId      = $group[0]->id;
                $viewsCount  = View::where('postId', $postId)->count();
                $likeCount   = Like::where('post_id', $postId)->where('like', 0)->count();
                $unLikeCount = Like::where('post_id', $postId)->where('like', 1)->count();
                $like        = $likeCount - $unLikeCount;

                return [
                    'id'            => $group[0]->id,
                    'userId'        => $group[0]->userId,
                    'userName'      => $group[0]->name,
                    'writerProfile' => $group[0]->writerProfile,
                    'email'         => $group[0]->email,
                    'AuthId'        => $group[0]->AuthId,
                    'genre'         => $group[0]->genre,
                    'title'         => $group[0]->title,
                    'content'       => $group[0]->content,
                    'views'         => $viewsCount,
                    'save'          => $group[0]->save,
                    'likeCount'     => $like,
                    'like'          => $group[0]->like,
                    'created_at'    => $group[0]->created_at,
                    'images'        => $group->map(function ($item) {
                        return [
                            'id'    => $item->id,
                            'image' => $item->path,
                        ];
                    })->unique('image')->filter()->values()->toArray(), // Get an array of image paths
                ];
            })->values();
        return $data;

    }

    private function getArchiveData($userId)
    {
        $data = Post::leftJoin('images', 'posts.id', '=', 'images.post_id')
            ->leftJoin('views', 'posts.id', '=', 'views.postId')
            ->leftJoin('users', 'posts.userId', '=', 'users.id')
            ->select('posts.*',
                'users.name',
                'users.image as writerProfile',
                'users.email',
                'posts.id',
                'posts.userId',
                'posts.genre',
                'posts.title',
                'posts.content',
                'images.path',
                'views.id as view_id',
                'posts.created_at',
                'posts.deleted_at')
            ->onlyTrashed()->get()->groupBy('id')
            ->map(function ($group) use ($userId) {
                $postId     = $group[0]->id;
                $viewsCount = View::where('postId', $postId)->count();
                return [
                    'id'            => $group[0]->id,
                    'userId'        => $group[0]->userId,
                    'userName'      => $group[0]->name,
                    'writerProfile' => $group[0]->writerProfile,
                    'email'         => $group[0]->email,
                    'genre'         => $group[0]->genre,
                    'title'         => $group[0]->title,
                    'content'       => $group[0]->content,
                    'views'         => $viewsCount,
                    'AuthId'        => $userId,
                    'created_at'    => $group[0]->created_at,
                    'deleted_at'    => $group[0]->deleted_at,
                    'images'        => $group->map(function ($item) {
                        return [
                            'id'    => $item->id,   // Image or product ID
                            'image' => $item->path, // Image URL
                        ];
                    })->unique('image')->filter()->values()->toArray(), // Get an array of image paths
                ];
            })->values();
        return $data;
    }

    private function checkToken($request)
    {
        $token = $request->bearerToken(); // Get the token from the Authorization header
        logger($token);
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
