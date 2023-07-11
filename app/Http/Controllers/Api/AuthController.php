<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function index(){

        $allUsers =User::all();
        return response()->json([
            'data'=>$allUsers
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'min:4'],
            'userName' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'userName' => $request->input('userName'),
            'password' => Hash::make($request->input('password')),
        ]);
            $createToken = $user->createToken($request->userName)->plainTextToken;

        return response()->json([
            'data'=>$user ,'token'=>$createToken
        ]);
    }

    public function login(Request $request) {
    $request->validate([
        'userName' => 'required',
        'password' => 'required',
    ]);
    $user = User::where('userName', $request->userName)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'userName' => ['The provided credentials are incorrect.'],
        ]);
    }
    $createToken = $user->createToken($request->userName)->plainTextToken;
    $userID = $user->token;
    return response()->json(['token'=> $createToken , 'user'=>$user]);
    }

    public function logout() {
        auth()->logout();
        return response()->json(201);
    }

}
