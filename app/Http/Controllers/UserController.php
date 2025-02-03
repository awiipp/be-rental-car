<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'no_ktp' => 'required',
            'name' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field',
            ], 422);
        }

        User::create([
            'username' => $request->input('username'),
            'no_ktp' => $request->input('no_ktp'),
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Create register success.'
        ], 200);
    }

    public function index()
    {
        if (Auth::user()->role != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $users = User::all();

        return response()->json([
            'success' => true,
            'users' => $users
        ], 200);
    }

    // public function edit($id)
    // {
    //     if (Auth::user()->role != 'admin') {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Forbidden'
    //         ], 403);
    //     }

    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found.'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'user' => $user
    //     ], 200);
    // }

    public function update(Request $request, string $id)
    {
        if (Auth::user()->role != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'no_ktp' => 'required',
            'name' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid field',
            ], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Register not found.'
            ], 404);
        }

        $user->update([
            'username' => $request->input('username'),
            'no_ktp' => $request->input('no_ktp'),
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update register success.'
        ], 200);
    }

    public function destroy(string $id)
    {
        if (Auth::user()->role != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Register not found.'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete register success.'
        ], 200);
    }
}
