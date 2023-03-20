<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response([
                'message' => 'Bad id'
            ], 401);
        };
        return response($user);
    }

    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Successfully Registered'
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // check password
        $user = User::where('username', $fields['username'])->first();

        // if(!$user || !Hash::check($fields['password'], $user->password)){
        //     return response([
        //         'message' => 'Invalid username or password.'
        //     ], 401);
        // }

        if(!$user || $fields['password'] != $user->password){
            return response([
                'message' => 'Invalid Credentials!'
            ], 401);   
        }


        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'OK'
        ];

        return response($response, 201);
    }

    public function logout(Request $request){

        if (!$request->user()) {
            return response(['message' => 'Unauthenticated!!.'], 401);
        }
        $request->user()->tokens()->delete();

        $response = [
            'message' => 'OK'
        ];

        return response($response, 201);
    }

    public function update(Request $request, $id){

        $user = User::find($id);
        if(!$user){
            return response([
                'message' => 'Bad id'
            ], 401);
        }
        $user->update($request->all());
        return response($user);
    }
}
