<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Dawnstar::auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request);

        if (Auth::guard('admin')->attempt($this->credentials($request), $request->filled('remember'))) {

            $request->session()->regenerate();

            $this->setSession();

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

    private function setSession()
    {
        $admin = auth('admin')->user();

        $website = Website::where('status', 1)->where('default', 1)->first();
        if($website) {
            $languages = $website->languages;
            $language = $website->languages()->wherePivot('default', 1)->first();
        }

        session([
            'dawnstar' => [
                'admin' => $admin,
                'website' => $website,
                'languages' => $languages ?? [],
                'language' => $language ?? null,
            ]
        ]);
    }
}
