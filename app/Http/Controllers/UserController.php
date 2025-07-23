<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
       public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }
       public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'user_role' => 'required|string|max:50', // Validate user_role
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_role' => $request->user_role, // Store user_role
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
        public function update(Request $request, User $user_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user_details)
    {
        //
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
