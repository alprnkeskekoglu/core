<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Admin;
use Dawnstar\Models\Language;
use Dawnstar\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        return view('DawnstarView::auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['status'] = 1;

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            $this->createAdminSession($request);
            $this->createWebsiteSession();
            $this->createLanguageSession();

            return redirect()->intended('dawnstar');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget('dawnstar');

        return redirect('dawnstar/login');
    }

    private function createAdminSession(Request $request)
    {
        $email = $request->get('email');

        $admin = Admin::where('email', $email)->first();

        session(['dawnstar.admin' => $admin]);
    }

    private function createWebsiteSession()
    {
        $website = Website::where('is_default', 1)->first();

        session(['dawnstar.website' => $website]);
    }

    private function createLanguageSession()
    {
        $language = Language::find(40);

        session(['dawnstar.language' => $language]);
    }
}
