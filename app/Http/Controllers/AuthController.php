<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Display the login view
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login submission
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $inputPassword = $request->password;

        // Fetch user record by email and active status
        $user = User::where('email', $email)
                    ->where('status', 'active')
                    ->first();

        if ($user) {
            $isPasswordValid = false;

            // Check if the stored password starts with $2y$ (Bcrypt hash from new registration)
            if (str_starts_with($user->password, '$2y$')) {
                if (Hash::check($inputPassword, $user->password)) {
                    $isPasswordValid = true;
                }
            } 
            // Otherwise, compare using MD5 (for older accounts)
            else {
                if ($user->password === md5($inputPassword)) {
                    $isPasswordValid = true;
                }
            }

            // If credentials match, set session and redirect
            if ($isPasswordValid) {
                session([
                    'user_id' => $user->user_id,
                    'name'    => $user->name,
                    'role'    => $user->role,
                ]);

                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard');
                } else {
                    return redirect('/assistant/dashboard');
                }
            }
        }

        return back()->with('error', 'Invalid Email or Password.');
    }

    // Handle logout
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}