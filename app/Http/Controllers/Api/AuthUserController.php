<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);

        $user = User::create($request->toArray());

        $token = $user->createToken('Token api')->accessToken;

        $response = ['token' => $token];

        return response($response, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('user', $request->user)->first();


        if(!$user)
            return response()->json([
                'error'=> true,
                'message'=>"User incorect",
                'response'=>422
            ],422);

        if (Hash::check($request->password, $user->password))
            return response()->json([
                 'error'=> true,
                 'token'=>$user->createToken('Token api')->accessToken,
                 'response'=>200
            ],200);

            return response()->json([
                'error'=> true,
                'message'=>"Password incorect",
                'response'=>422
            ],422);


    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'revokeToken'=> true,
            'message'=>"You have been successfully logged out!",
            'response'=>200
        ],200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Bienes  $bienes
     * @return \Illuminate\Http\Response
     */
    public function show(Bienes $bienes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bienes  $bienes
     * @return \Illuminate\Http\Response
     */
    public function edit(Bienes $bienes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bienes  $bienes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bienes $bienes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bienes  $bienes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bienes $bienes)
    {
        //
    }
}
