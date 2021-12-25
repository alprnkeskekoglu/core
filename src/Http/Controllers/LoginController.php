<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Core::auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request);

        if (Auth::guard('admin')->attempt($this->credentials($request), $request->filled('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout()
    {
        auth('admin')->logout();

        session()->forget('dawnstar');

        return redirect()->route('dawnstar.login.index');
    }

    private function validate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }

    private function credentials(Request $request)
    {
        return [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'status' => 1
        ];
    }
}
