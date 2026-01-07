<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Register a new user (API JSON).
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'max:100', 'unique:clients,email'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Client::create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Registration successful', 'user' => $user, 'ok' => true], 201);
    }
}
