<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException; //dipakai untuk situasi kalo ada kesalahan
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'id_divisi' => 'required',
        ]);

        // menambah cek ke database email ini udah di gunakan blm
        $User = User::where('email', $req->email)->first();
        if ($User) {
            return response()->json([
                'message' => 'Email sudah terdaftar.',
                'code' => 400
            ], 400);
        }
        
        try {
            $user= User::create([
                'id' => Str::uuid()->toString(), //Universally Unique Identifier 
                'name' => $req->name,
                'email' => $req->email,
                'password' => $req->password,
                'role_id' => $req->role_id,
                'id_divisi' => $req->id_divisi
            ]);

            return response()->json([
                    'message' => 'registrasi berhasil'
                ], 200);

            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => 500
            ],500);
        }
        // return response()->json([
        //     'message' => 'registrasi berhasil'
        // ], 200);
    }


    public function login(Request $req)
    {   
        $credentials = $req->only('name', 'password');
        $validator = Validator::make($credentials, [
            'name' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->getMessageBag(),
                'code' => 400
            ],400);
        }
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Harap periksa kembali name atau password anda!',
                    'code' => 400
                ],400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => 500
            ],500);
        }

        $User = User::select('id', 'name', 'email','role_id','id_divisi')
        ->where('name', '=', JWTAuth::user()->name)
        ->first();
    

        return response()->json([
            'message' => 'success, anda berhasil login',
            'data' => $User,
            'token' => $token
        ], 200);
    } 


    public function index()
    {
        try {
            $users = User::all();

            return resJson(1, "success", $users, 200);

        } catch (\Exception $e) {
    
            return resJson(0, "error", $users, 500);
        }
    } 
}