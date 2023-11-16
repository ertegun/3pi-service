<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class M2M_authMiddleware
{
    public function handle($request, Closure $next)
    {
        // Requestten client_id ve client_secreti alma
        $clientId = $request->input('client_id');
        $clientSecret = $request->input('client_secret');

        // client_id ve client_secretin doğruluğunu kontrol etme
        if (!$this->validateCredentials($clientId, $clientSecret)) {
            return response()->json(['message' => 'Geçersiz kimlik bilgileri'], 401);
        }


        
        // Token doğrulama işlemi
        if (!Auth::guard('api')->check()) {
            return response()->json(['message' => 'Yetki yok'], 401);
        }


        return $next($request);
    }

    private function validateCredentials($clientId, $clientSecret)
    {
        //
       // return $clientId === '' && $clientSecret === '';
    }
}
