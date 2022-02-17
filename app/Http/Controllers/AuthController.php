<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller{
    

    public function login(Request $request){

        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string']
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            PersonalAccessToken::where('name', $request->email)->delete();

            return response()->json([
                'success' => true, 
                'token' => $request->user()->createToken($request->user()->email)->plainTextToken
            ], 200);
            
        }

    }
    
    public function logout(Request $request){
        return $request->user()->currentAccessToken()->delete();
    }

}
