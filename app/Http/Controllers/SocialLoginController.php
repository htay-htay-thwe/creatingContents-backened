<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //redirect
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();

    }

    //callback
    public function callback($provider){
        $socialUser = Socialite::driver($provider)->user();

            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name,
                'nickname' => $socialUser->nickname,
                'image' => $socialUser->avatar ,
                'email' => $socialUser->email,
                'provider_token' => $socialUser->token,
                'provider' => $provider,
                'role' => 'admin',

            ]);

            Auth::login($user);
            return redirect()->route('get#data')->with('success', 'Login Successfully!');
        }

    public function redirectApi($provider){
        return Socialite::driver($provider)->redirect();
        logger($provider);
    }

    //callback
    public function callbackApi($provider,Request $request){
        $socialUser = Socialite::driver($provider)->user();
        $userPro = User::where('email', $socialUser->getEmail())->first();

        if($userPro->provider === $socialUser->provider){
            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name,
                'nickname' => $socialUser->nickname,
                'image' => $socialUser->avatar ,
                'email' => $socialUser->email,
                'provider_token' => $socialUser->token,
                'provider' => $provider,
                'role' => 'admin',

            ]);
            $token = JWTAuth::fromUser($user);
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $userPro,
        ]);
        }else{
            return response()->json(['error' => 'Account with this email already exists!'], 409); // 409 Conflict
        }

    }
}
