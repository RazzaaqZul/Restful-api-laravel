<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
}
