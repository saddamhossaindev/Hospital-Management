<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function ApiLogin(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];
        $input     = $request->only('email','password');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = auth()->user();
            $user->api_token = Str::random(60);
            $user->save();
            return $user;
        }
        
        return response()->json([
            'error' => 'Unauthenticated user',
            'code' => 401,
        ], 401);
    }
}
