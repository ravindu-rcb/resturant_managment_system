<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:cook,cashier,manager',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        Auth::login($user);
        return redirect()->route($this->routeForRole($user->role));
    }

    private function routeForRole(string $role): string
    {
        return match ($role) {
            'cook'    => 'kitchen.index',
            'manager' => 'concessions.index',
            default   => 'orders.index', // cashier
        };
    }
}
