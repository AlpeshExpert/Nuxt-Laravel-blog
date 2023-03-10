<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        if(!Auth::attempt($request->only('email','password'))){
            throw new AuthenticationException();
        }
    }
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
