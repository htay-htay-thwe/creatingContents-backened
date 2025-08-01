<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\post;
use App\Models\User;
use App\Models\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class PostController extends Controller
{

    public function getData()
    {
        $posts = post::count();
        $users = User::count();
        logger($users);
        $data           = $this->getCommonData();
        $dataCollection = collect($data);
        $perPage        = 5;
        $currentPage    = LengthAwarePaginator::resolveCurrentPage();
        $items          = $dataCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginator      = new LengthAwarePaginator(
            $items,
            $dataCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $popular = $data->filter(function ($post) {
            return $post['views'] >= 50;
        })->count();
        return view('dashboard', compact('posts', 'users', 'data', 'popular'))->with('paginator', $paginator);
    }

    public function deletePost($id)
    {
        Post::where('id', $id)->delete();
        Like::where('post_id', $id)->delete();
        View::where('postId', $id)->delete();
        return redirect()->route('get#data')->with('success', 'Post deleted successfully.');
    }

    public function manageAcc()
    {
        $posts   = post::count();
        $users   = User::count();
        $data    = $this->getCommonData();
        $popular = $data->filter(function ($post) {
            return $post['views'] >= 50;
        })->count();
        $user = User::paginate(7);
        return view('pages.user-pages.userAcc', compact('posts', 'users', 'data', 'popular', 'user'));
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('manage#acc')->with('success', 'User deleted successfully.');
    }

    private function getCommonData()
    {
        $data = Post::leftJoin('images', 'posts.id', '=', 'images.post_id')
            ->leftJoin('views', 'posts.id', '=', 'views.postId')
            ->leftJoin('users', 'posts.userId', '=', 'users.id')
            ->leftJoin('saves', 'posts.id', '=', 'saves.post_id')
            ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
            ->select('posts.*',
                'posts.id',
                'posts.userId',
                'posts.created_at as time',
                'users.name',
                'users.image as writerProfile',
                'users.email',
                'posts.genre',
                'posts.title',
                'posts.content',
                'images.path',
                'saves.save',
                'saves.userId as AuthId',
                'likes.like')
            ->get()->groupBy('id')
            ->map(function ($group) {
                $postId      = $group[0]->id;
                $viewsCount  = View::where('postId', $postId)->count();
                $likeCount   = Like::where('post_id', $postId)->where('like', 0)->count();
                $unLikeCount = Like::where('post_id', $postId)->where('like', 1)->count();
                $like        = $likeCount - $unLikeCount;

                $date    = Carbon::createFromFormat('Y-m-d H:i:s', $group[0]->time);
                $now     = Carbon::now();
                $timeAgo = $date->diffForHumans($now);

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
                    'time'          => $timeAgo,
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
}
