<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login.'
            ], 401);
        }

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login'
            ], 401);
        }

        $user = Auth::user(); // error ga tau kenapa.
        // $user = User::where('username', $request->input('username'));
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        if (!Auth::user()->tokens()->delete()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised user.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout success.'
        ], 200);
    }
}
