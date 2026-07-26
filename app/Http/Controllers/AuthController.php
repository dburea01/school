<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthorizesRequests;

    public function logout(Request $request): RedirectResponse
    {
        $this->logoutAndFlush($request);

        return redirect('/');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember_me'))) {

            /** @var User $user */
            $user = Auth::user();

            if ($user->status !== UserStatus::ACTIVE) {
                $this->logoutAndFlush($request);

                return back()->with('error', 'Utilisateur non autorisé à se connecter. Contactez votre administrateur.')->withInput();
            }

            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('error', 'Impossible de se connecter avec ce couple email/mot de passe.')->withInput();
    }

    private function logoutAndFlush(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
