<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function register(UserRegisterRequest $request) : JsonResponse {
        // ambil data yang selesai di validasi
        $data = $request->validated();

        // check di Database tidak ada value unique yang sama
        if(User::where('username', $data['username'])->count() == 1){
            // Bad Request
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ],400));
        }

        // jika sudah valid
        // pastikan $fillable atau data yang dapat diubah pada model
        $user = new User($data);

        // Mengubah password dengan hashing bycrypt
        $user->password = Hash::make($data['password']);
        // otomatis di hashing dan disimpan dalam varabel
        // simpan dalam database
        $user->save();

        // default returnStatusCode adalah 200
        // oleh karena itu diubah 
        return (new UserResource($user))->response()->setStatusCode(201);

    }


    public function login(UserLoginRequest $request) : UserResource {

        $data = $request->validated();

        // Cari di DB
        // Ambil data yg pertama ditemukan
        $user = User::where('username', $data['username'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401));
        }

        // ubah token menjadi unique ID
        $user->token = Str::uuid()->toString();

        $user->save();

        // Kalau mau default 200, tidak perlu pakai JSONResponse
        // cukup memakai class Responses
        return new UserResource($user);
    }

    public function get(Request $request) : UserResource {
        // Ambil header untuk mendapatkan data
        // ambil user yang saat ini sedang login
        $user = Auth::user();
        return new UserResource($user);

    }

    public function update(UserUpdateRequest $request) : UserResource {
        $data = $request->validated();
        // ambil data dari user
        $user = Auth::user();


        if(isset($data['name'])){
            $user->name = $data['name'];
        }

        if(isset($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        // insert ke DB
         $user->save();
        return new UserResource($user);
    }

    public function logout(Request $request) : JsonResponse {
        $user = Auth::user();

        $user->token = null;
        $user->save();

        return response()->json([
            "data" => true
        ])->setStatusCode(200);
        
    }

}
