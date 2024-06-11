<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ambil token
        $token = $request->header("Authorization");

        $authenticate = true;

        // Kalau misalkan token nya tidak ada
        if(!$token) {
            // tidak ter authentikasi
            $authenticate = false;
        }

        // Cek kesamaan token di DB
        $user = User::where("token", $token)->first();
        if(!$user) {
            $authenticate = false;
        } else {
            // Facade Auth dengan method Login yang akan registrasikan data ke session
            // dalam menggunakan facade tersebut harus Authenticable
            // jadi agar didukung Authenticable, implement semua mehod pada User Model.
            Auth::login($user);
        }

      

         // Di request selanjutnya, jika ingin mendapatkan data user pakai Auth::user();

        // Jika ter-authentikasi
        if($authenticate) {
            // lanjutkan ke controller selanjutnya
            return $next($request);
        } else {
            return response()->json([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ])->setStatusCode(401);
        }


    }
}
