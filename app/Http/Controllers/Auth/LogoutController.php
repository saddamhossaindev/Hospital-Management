<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $rules = [
            'email'    => 'required',
        ];
        $input     = $request->only('email');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->api_token = null; // clear api token
            $user->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Thank you for using our application',
            ]);
        }
        
        return response()->json([
            'success' => false,
            'error' => 'Unable to logout',
            'code' => 422,
        ], 422);
    }
}
