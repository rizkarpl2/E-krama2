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
        ]);

        // menambah cek ke database email ini udah di gunakan blm
        $users = User::where('email', $req->email)->first();
        if ($users) {
            return response()->json([
                'status'=> 0 ,
                'message' => 'Email sudah terdaftar',
                'code' => 400
            ], 400);
        }
        
        try {
            $users= User::create([
                'id' => Str::uuid()->toString(), //Universally Unique Identifier 
                'name' => $req->name,
                'email' => $req->email,
                'password' => $req->password,
                'role_id' => $req->role_id,
            ]);
            return resJson(1,"Registrasi berhasil",$users,200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }


    public function login(Request $req)
    {   
        $credentials = $req->only('name', 'password');
        $validator = Validator::make($credentials, [
            'name' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return resJson(
                0,
                'error',
                $validator->getMessageBag(),
                500
            );
        }
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return resJson(0,'Harap periksa kembali name atau password anda',$e,400);
            }
        } catch (JWTException $e) {
            return resJSON(0,
                'error',
                $e->getMessage(),
                500
            );
        }

        $users = User::select('id', 'name', 'email','role_id')
        ->where('name', '=', JWTAuth::user()->name)
        ->first();
    

        return response()->json([
            'status' => '1',
            'message' => 'success, anda berhasil login',
            'data' => $users,
            'token' => $token
        ], 200);        
    } 


    public function index()
    {
        try {
            $users = User::all();
            $users = User::orderBy('created_at','desc')->get();

            return resJson(1, "success", $users, 200);

        } catch (\Exception $e) {
            return resJson(0, "error", $users, 500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    } 
}