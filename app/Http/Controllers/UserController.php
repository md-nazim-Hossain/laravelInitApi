<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
class UserController extends Controller
{
    public function users(string $id = null)
    {
        $users = $id ?User::findOrFail($id) : User::get();
        return response()->json(["users"=>$users], 200);
    }

    public function signup(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];

        $customMessages = [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
        ];

        $validator = Validator::make($data,$rules,$customMessages);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(attributes: [

            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $messgae = 'User created successfully';
        return response()->json(["message"=>$messgae], 200);
    }

    public function login(Request $request){
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
        ];

        $validator = Validator::make($data,$rules,$customMessages);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $user = User::where('email', $data['email'])->first();

        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        if(!Hash::check($data['password'], $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['user' => $user], 200);
    }


}
