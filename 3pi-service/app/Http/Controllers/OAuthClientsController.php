<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Auth;

class OAuthClientsController extends Controller
{
    public function createClient(Request $request)
    {
        // Giriş yapmış kullanıcının bilgilerine ulaşmak için auth:api middleware'ini ekliyoruz.
        // $this->middleware('auth:api');

        // Giriş yapmış kullanıcının ID'sini alıyoruz.
        $userId = Auth::user()->id;

        // OAuth Client oluşturma işlemi
        $user = Auth::user();

        if ($user) {
            $client = new Client();
            $client->user_id = $user->id;
            $client->name = 'Client';
            $client->redirect = 'http://3pi-service.test/callback';

            
            $clientSecret = bin2hex(random_bytes(32));
            $client->secret = $clientSecret;

            $client->personal_access_client = false;
            $client->password_client = true;
            $client->revoked = false;
            $client->save();

            return response()->json([
                'message' => 'Başarıyla oluşturuldu',
                'client_id' => $client->id,
                'client_secret' => $clientSecret,
                'user_id' => $user->id,
            ]);
        }

        return response()->json([
            'message' => 'Kullanıcı bulunamadı',
        ], 404);
    }
}
