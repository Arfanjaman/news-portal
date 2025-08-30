<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Middleware\Admin; // Remove or comment out this line if not needed
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\HandleLoginRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Http\Requests\AdminResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminSendResetLinkMail;
class AdminAuthenticationController extends Controller
{

    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(HandleLoginRequest $request)
    {
        try {
            $request->authenticate();

            // Regenerate session to prevent session fixation added by copilot
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput($request->except('password'));
        }
    }

    public function logout(Request $request) :RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(SendResetLinkRequest $request)
    {

        $token = Str::random(64);
        $admin= Admin::where('email', $request->email)->first();
        $admin->remember_token = $token;
        $admin->save();

        Mail::to($request->email)->send(new AdminSendResetLinkMail($token , $request->email));
        return redirect()->back()->with('success', 'We have emailed your password reset link!');
    }
    public function resetPassword($token)
    {
        return view('admin.auth.reset-password' , compact('token'));
    }

    public function handleResetPassword(AdminResetPasswordRequest $request)
    {

        $admin = Admin::where(['email'=> $request->email ,'remember_token'=> $request->token])->first();
        if (!$admin) {
            return redirect()->back()->withErrors(['email' => 'Invalid token or email.']);
        }

        $admin->password = bcrypt($request->password);
        $admin->remember_token = null; // Clear the token after successful reset
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Your password has been reset successfully. You can now log in with your new password.');

    }



}
