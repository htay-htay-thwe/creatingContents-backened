<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\post;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserwController extends Controller
{
    public function changePassword()
    {
        $posts = post::count();
        $users = User::count();
        $data = $this->getCommonData();
        $popular = $data->filter(function ($post) {
            return $post['views'] >= 50;
        })->count();
        $user = User::paginate(7);
        return view('pages.user-pages.password', compact('posts', 'users', 'data', 'popular', 'user'));
    }

    public function changePasswordForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'newPassword' => 'required|min:8',
            'oldPassword' => 'required|min:8',
            'confirmedPassword' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('/change/password')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->newPassword === $request->confirmedPassword){
            $user = User::where('id', $request->userId)->first();
            if (Hash::check($request->oldPassword,$user->password )) {
                User::where('id', $request->userId)->update(['password' => Hash::make($request->newPassword)]);
                return redirect()->back()->with('success', 'Password updated successfully.');
            } else {
                return redirect()->back()->with('conFail', 'The old password is incorrect.');
            }
        }else{
            return redirect()->back()->with('conFail', 'NewPassword and ConfirmedPassword Not Match!');
        }

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function adminAcc($id)
    {

        $posts = post::count();
        $users = User::count();
        $data = $this->getCommonData();
        $popular = $data->filter(function ($post) {
            return $post['views'] >= 50;
        })->count();
        $user = User::where('id', $id)->first();

        return view('pages.user-pages.adminInfo', compact('posts', 'users', 'data', 'popular', 'user'));
    }

    public function updateAdminAcc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required_without:image',
            'image' => 'required_without:userName',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin#acc',['id' => $request->userId])
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $fileName);
            User::where('id', $request->userId)->update([
                'image' => $fileName,
            ]);
        }
        if ($request->userName) {
            User::where('id', $request->userId)->update([
                'name' => $request->userName,
            ]);
        }
        return redirect()->back()->with('success', 'Update Success!');
    }

    public function registerPage()
    {
        return view('pages.user-pages.register');
    }

    public function loginPage()
    {
        return view('pages.user-pages.login');
    }

    public function registerAcc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('/register/page')
                ->withErrors($validator)
                ->withInput();
        }
        User::create([
            'name' => $request->userName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        Auth::login(User::where('email', $request->email)->first());
        return redirect()->route('get#data')->with('success', 'Registered Successfully!');
    }

    public function loginAcc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('/login/page')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect('/login/page')->with('error', 'User does not exist!');
        }else if(!Hash::check($request->password, $user->password)){
                return redirect('/login/page')->with('error', 'Password is incorrect!');
        }
        if($user->role == "admin"){
        Auth::login($user);
        }
        return redirect()->route('get#data')->with('success', 'Login Successfully!');

    }

    public function logOut(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/page')->with('success', 'Logged out successfully!');
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
                $postId = $group[0]->id;
                $viewsCount = View::where('postId', $postId)->count();
                $likeCount = Like::where('post_id', $postId)->where('like', 0)->count();
                $unLikeCount = Like::where('post_id', $postId)->where('like', 1)->count();
                $like = $likeCount - $unLikeCount;

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $group[0]->time);
                $now = Carbon::now();
                $timeAgo = $date->diffForHumans($now);

                return [
                    'id' => $group[0]->id,
                    'userId' => $group[0]->userId,
                    'userName' => $group[0]->name,
                    'writerProfile' => $group[0]->writerProfile,
                    'email' => $group[0]->email,
                    'AuthId' => $group[0]->AuthId,
                    'genre' => $group[0]->genre,
                    'title' => $group[0]->title,
                    'content' => $group[0]->content,
                    'views' => $viewsCount,
                    'save' => $group[0]->save,
                    'likeCount' => $like,
                    'like' => $group[0]->like,
                    'time' => $timeAgo,
                    'images' => $group->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'image' => $item->path,
                        ];
                    })->unique('image')->filter()->values()->toArray(), // Get an array of image paths
                ];
            })->values();
        return $data;

    }

}
