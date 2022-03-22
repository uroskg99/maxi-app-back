<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Admin;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExceptions;

class AuthController extends Controller
{
    public function register(Request $request) {

        $admin = Admin::where('email', $request['email'])->first();

        if($admin) {
            $response['status'] = 0;
            $response['message'] = 'Email already exists';
            $response['code'] = 409;
        } else {
            $admin = Admin::create([
                'username' => $request->input("username"),
                'email' => $request->input("email"),
                'password' => bcrypt($request->input("password"))
            ]);
    
            $response['status'] = 1;
            $response['message'] = 'Admin registered successfully';
            $response['code'] = 200;
        }

        return response()->json($response);
    }

    public function login(Request $request) {

        $credentials = $request->only('email', 'password');
        
        try {
            if(!JWTAuth::attempt($credentials)) {
                $response['status'] = 0;
                $response['code'] = 401;
                $response['data'] = null;
                $response['message'] = 'Email or password is incorrect';
                
                return response()->json($response);
            }
        } catch(JWTException $e) {
            $response['data'] = null;
            $response['code'] = 500;
            $response['message'] = 'Could not create token';

            return response()->json($response);
        }

        $admin = auth()->user();
        $data['token'] = auth()->claims([
            'admin_id' => $admin->id,
            'email' => $admin->email
        ])->attempt($credentials);

        $response['data'] = $data;
        $response['status'] = 1;
        $response['code'] = 200;
        $response['message'] = 'Login successfully';

        return response()->json($response);
    }
}
