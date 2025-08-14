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
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'user_role' => 'required|in:admin,teller',
        ]);
        // Create the use

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_role' => $request->user_role,
        ]);


        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    public function update(Request $request, $id)
    {
        // dd(
        // $request->validate([
        //     'username' => 'required|string|max:255',
        //     'useremail' => 'required|string|email|max:255',
        //     'userrole' => 'required|in:admin,teller',
        // ]));

        $user = User::findOrFail($id);

        try {
            $user->name = $request->input('username');
            $user->email = $request->input('useremail');
            $user->user_role = $request->input('userrole');
            $user->save();


            return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user_details)
    {
        //

        $user = User::findOrFail($user_details->id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
