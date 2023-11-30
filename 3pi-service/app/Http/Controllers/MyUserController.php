<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Models\User;
class MyUserController extends Controller
{

    public function register(Request $request)
{
    $requestData = $request->all();

    // Doğrulama kuralları ve özelleştirilmiş hata mesajları
    $validator = Validator::make($requestData, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // Burada 'users' tablosunu kontrol ediyoruz
        'password' => 'required|string|min:6|max:255',
    ], [
        // ... hata mesajları ...
    ]);

    // Doğrulama başarısız olursa
    if ($validator->fails()) {
        return response()->json(['message' => 'Bilgiler eksik veya hatalı.', 'errors' => $validator->errors()], 400);
    }

    // Doğrulama başarılıysa
    $data = User::create([
        'name' => $requestData['name'],
        'email' => $requestData['email'],
        'password' => Hash::make($requestData['password']),
    ]);

    //return apiResponse('Message', 200, $data);
    return response()->json(['message' => 'Kayıt başarılı.', 'data' => $data], 201);
}

/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Auth"},
 *     summary="Kullanıcı Girişi",
 *     description="Kullanıcı girişi sağlar ve bir erişim belirteci döndürür.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Kullanıcı girişi bilgileri",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"email", "password"},
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     description="Kullanıcı e-posta adresi"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     format="password",
 *                     description="Kullanıcı şifresi"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Başarılı giriş, erişim belirteci döndürür",
 *         @OA\JsonContent(
 *             @OA\Property(property="access_token", type="string"),
 *             @OA\Property(property="token_type", type="string"),
 *             @OA\Property(property="expires_in", type="integer"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Kimlik doğrulama hatası",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Eksik veya hatalı istek",
 *         @OA\JsonContent(@OA\Property(property="message", type="string"))
 *     )
 * )
 */
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    $validator = Validator::make($credentials, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Bilgiler eksik veya hatalı', 'errors' => $validator->errors()], 401);
    }

    $http = Http::asForm()->post(config('app.url') . '/oauth/token', [
        'grant_type' => 'password',
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
        'username' => $request->email,
        'password' => $request->password,        'scope' => '*',
    ]);

    if ($http->failed()) {
        return response()->json(['message' => 'Kimlik doğrulama başarısız oldu'], 401);
    }

    $tokenData = $http->json();

    return response()->json([
        'access_token' => $tokenData['access_token'],
        'token_type' => $tokenData['token_type'],
        'expires_in' => $tokenData['expires_in'],
        'refresh_token' => isset($array['refresh_token']) ? $array['refresh_token'] : null,
    ]);
}

public function getClientCredentialsToken()
{
    try {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            //'grant_type' => 'client_credentials',
            //'client_id' => '4',
            //'client_secret' => 'maONU6tkWSHUNwclG3Dwi1RrKKemBHGpC50frSS7',
            //'scope' => '*',
        ]);

        $responseData = $response->json();

        return response()->json([
            'access_token' => $responseData['access_token'],
            'expires_in' => $responseData['expires_in'],
        ]);
    } catch (\Exception $e) {
        // Hata durumunda buraya düşecek
        return response()->json(['error' => 'token alınamıyor'], 500);
    }
}


public function creatClientSecret()
{
    try {
        $response = Http::asForm()->post(config('app.url') . '/oauth/clients', [
            'grant_type' => 'client_credentials',
            'client_id' => '4',
            'client_secret' => 'maONU6tkWSHUNwclG3Dwi1RrKKemBHGpC50frSS7',
            'scope' => '*',
        ]);

        $responseData = $response->json();

        return response()->json([
            'access_token' => $responseData['access_token'],
            'expires_in' => $responseData['expires_in'],
        ]);
    } catch (\Exception $e) {
        // Hata durumunda buraya düşecek
        return response()->json(['error' => 'token alınamıyor'], 500);
    }
}
}
