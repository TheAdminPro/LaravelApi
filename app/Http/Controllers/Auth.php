<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Auth extends Controller
{

    // Search User
    public function user(Request $request)
    {   
        $search = explode(" ", $request->search);
        $search[1] = count($search) == 2 ? $search[1] : "";
        
        $user = User::where([
            ['name', 'like', '%'.$search[0].'%'],
            ['email', 'like', '%'.$search[1].'%'],
        ])->get();

        return response()->json(['users' => $user], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        $token = $request->header('token');

        $user = User::where('api_token', $token)->first();

        $user->api_token = '';
        $user->save();

        return response()->json([], 200);
    }

    // Login
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $m = [
            'required'=> 'req :attribute'
        ];

        $v = Validator::make(
                $request->all(),
                $rules,
                $m
            );



        if ($v->fails()) {
            return response()
                    ->json($v->messages(), 422);
        }


        $user = User::where('email', $request->email)->first();

        $check = Hash::check(
            $request->password,
            $user->password);

        if ($check) {
            $user->api_token = Str::random(80);
            $user->save();

            return response()
                    ->json(['token'=> $user->api_token], 200);
        } else {
            return response()
                    ->json(['login'=> 'incorrect login or password'], 404);
        }
    }

    // Signup
    public function signup(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50',
            'password' => 'required'
        ];

        $m = [
            'required'=> 'req :attribute'
        ];

        $v = Validator::make(
                $request->all(),
                $rules,
                $m
            );



        if ($v->fails()) {
            return response()
                    ->json($v->messages(), 422);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'id'=> $user->id
        ], 201);
    }
}
