<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;



class M2M_authMiddleware

    {
        public function handle(Request $request, Closure $next)
    {
        // Kullanıcı giriş yapmış mı kontrol et
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Kullanıcı giriş yapmışsa
        $user = Auth::user();

        if ($user) {
            // Kullanıcı idsini al
            $userId = $user->id;
        } else {
            
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
