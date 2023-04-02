<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        if (!$request->has('username') || !$request->has('password')) {
            return response()->json([
                'status' => false,
                'message' => 'username and password is require'
            ], 500);
        }

        $client = Clients::where('username', $request->username)->first();

        if(!$client) {
             return response()->json([
                'status' => false,
                'message' => 'User not found'
             ], 404);
        }

        if (Hash::check($request->password, $client->password)) {
            $token = $client->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' =>  $token
             ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Wrong password'
             ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $client = Clients::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($client, 200);
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
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients)
    {
        //
    }
}
