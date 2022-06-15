<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use Illuminate\Auth\Events\Validated;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'status' => 'required',
            'password' => 'required|min:6'
        ],
        [
            'required'  => ':attribute harus diisi',
            'min'       => ':attribute minimal :6 karakter',
            'max'       => ':attribute minimal :12 karakter',
        ]);

    if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Data Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

            } else {

                
            $password = Hash::make($request->input('password'));
            $users = Users::create([
                'username'     => $request->input('username'),
               
                'status'   => $request->input('status'),
                'password'   => $password,
                
            ]);

            if ($users) {
                return response()->json([
                    'success' => true,
                    'message' => 'Users Berhasil Disimpan!',
                    'data' => $users
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Users Gagal Disimpan!',
                ], 400);
            }

    }


    }


    public function login(Request $request)
    {
        
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
  
        $username = $request->input('username');
        $password = $request->input('password');
  
        $user = Users::where('username', $username)->first();
        if (!$user) {
            return response()->json([
                'succcess' => false,
                'message' => 'Login failed'
            ], 401);
        }
  
        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
          return response()->json([
            'succcess' => false,
            'message' => 'Login failed'
            
        ], 401);
        }
  
        $generateToken = JWTAuth::fromuser($user);
        // $user->update([
        //     'token' => $generateToken
        // ]);
  
        return response()->json([
            'success' => true,
            'message' => "Berhasil Login",
            'data' =>$user,
            'token' =>$generateToken
        ], 200);
    }

}