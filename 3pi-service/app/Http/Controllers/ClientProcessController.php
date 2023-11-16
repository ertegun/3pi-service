<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

           $http = Http::asForm()->post(config('app.url') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '*',
                'provider' => 'user',
            ]);
            if ($http->failed()) {
              //  dd( env('PASSPORT_CLIENT_ID'), env('PASSPORT_CLIENT_SECRET'));
                return response()->json(['message' => 'Kimlik doğrulama başarısız oldu'], 401);
            }
            $tokenData = $http->json();
            return response()->json([
                'access_token' => $tokenData['access_token'],
                'token_type' => $tokenData['token_type'],
                'expires_in' => $tokenData['expires_in'],
            ]);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
