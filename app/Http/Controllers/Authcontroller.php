<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use Password;
use Str;


use App\Models\User;
use App\Models\Profile;


class Authcontroller extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        // validate data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember_me = $request->has('remember_me') ? true : false; 

        // Check user type and redirect them as per their type
        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();
 
            $dashboard = Auth::user()->type == 'admin' ? route('admin.dashboard') : route('user.dashboard') ;
            $message = Auth::user()->type == 'admin' ? 'You are logged in as a Admin.' : 'You are logged in as a User.' ;
           
            Alert('Logged in',$message);
            return redirect($dashboard);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function register() {
        return view('auth.register');
    }

    public function store(Request $request) {
        // validate data
        $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'password' => 'required',
        ]);

        if($request->password == $request->confirm_password) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            Profile::create([
                'user_id' => $user->id
            ]);
            Alert('User registered','You are redirecting to your dashboard.');
            return redirect()->route('login');; 
        }
        return back();
    }

    // Handle logout of user(user and vendor both)
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert('Logout Successfully','You are redirecting to Homepage');
        return redirect('/');
    }

    // Request password after forgot password
    public function forgot_password() {
        return view('auth.forgot_password');
    }

    // handle forgot password form data
    function send_password_reset_email(Request $request) {
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // reset password using token recived in email
    public function reset_password(string $token) {
        return view('auth.reset_password', ['token' => $token]);
    }

    // update password after reset password form submit
    public function update_password(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
            }
        );
    
        if($status === Password::PASSWORD_RESET) {
            Alert('Password changed','Password changed successfully.');
            return redirect()->route('login')->with('status', 'Your password has been changed.');
        }
        return back()->withErrors(['email' => [__($status)]]);
    }




    
}
