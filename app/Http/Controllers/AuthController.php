<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Http\Requests\PasswordResetRequest;
use App\Mail\PasswordResetLink;
use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

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

    public function passwordResetRequest(Request $request): RedirectResponse
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        $message = "Un email de re initialisation de mot de passe vient d'être envoyé.";

        /** @var string $email */
        $email = $request->email;

        if (! $user) {

            Log::info('[PASSWORD_LOST] impossible to send passwordResetRequestMail to the unknown email '.$email);

            return back()->with('success', $message);
        }

        DB::beginTransaction();
        $token = Str::random(40);

        try {

            PasswordResetToken::where('email', $request->email)->delete();

            /** @var int $delay */
            $delay = config('params.delay_validity_token_reset_password');

            $passwordResetToken = new PasswordResetToken;
            $passwordResetToken->email = $email;
            $passwordResetToken->token = $token;
            $passwordResetToken->created_at = now();
            $passwordResetToken->expire_at = Carbon::now()->addMinutes($delay);
            $passwordResetToken->save();

            Mail::to($user)->send(new PasswordResetLink(
                $user,
                $token,
                $delay
            ));
            // Mail::to($user)(new PasswordResetRequestMail($user, $token, config('params.delay_validity_token_reset_password')));
            Log::info('[PASSWORD_LOST] email passwordResetRequestMail sent to '.$email);
            DB::commit();

            return back()->with('success', $message);
        } catch (\Exception $ex) {
            Log::error('Error to send email password lost for user '.$user->email);
            Log::error($ex->getMessage());
            DB::rollback();

            return back()->with('error', 'Echec de la demande. Email non envoyé');
        }
    }

    public function formPasswordReset(string $token): View
    {
        $passwordReset = PasswordResetToken::where('token', $token)->firstOrFail();
        $user = User::where('email', $passwordReset->email)->firstOrFail();

        return view('auth.password-reset', [
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function passwordReset(PasswordResetRequest $request): RedirectResponse
    {
        $passwordReset = PasswordResetToken::where('token', $request->validated('token'))
            ->where('expire_at', '>=', date('Y-m-d H:i'))
            ->firstOrFail();
        $user = User::where('email', $passwordReset->email)->firstOrFail();

        DB::beginTransaction();
        try {
            /** @var string $password */
            $password = $request->validated('password');
            User::where('id', $user->id)
                ->update([
                    'password' => Hash::make($password),
                ]);

            PasswordResetToken::where('email', $user->email)->delete();
            // send email ?

            DB::commit();

            return redirect('/login')
                ->with('success', 'Mot de passe réinitialisé, vous pouvez vous connecter.');
        } catch (\Throwable $th) {
            Log::error('password of user '.$user->id.' not modified. '.$th->getMessage());
            DB::rollBack();

            return back()->with('error', 'Mot de passe non modifié');
        }
    }

    public function formActivateAccess(string $token): View
    {
        $passwordReset = PasswordResetToken::where('token', $token)->firstOrFail();
        $user = User::where('email', $passwordReset->email)->firstOrFail();

        if ($user->canConnect() && $user->emailIsValidated()) {
            abort(404, 'Utilisateur déjà activé.');
        }

        return view('auth.activate-access', [
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function activateAccess(PasswordResetRequest $request): RedirectResponse
    {
        $passwordReset = PasswordResetToken::where('token', $request->validated('token'))
            ->where('expire_at', '>=', date('Y-m-d H:i'))
            ->firstOrFail();
        $user = User::where('email', $passwordReset->email)->firstOrFail();

        if ($user->canConnect() && $user->emailIsValidated()) {
            abort(404, 'Utilisateur déjà activé.');
        }

        DB::beginTransaction();
        try {
            /** @var string $password */
            $password = $request->validated('password');
            User::where('id', $user->id)
                ->update([
                    'password' => Hash::make($password),
                    'email_validated_at' => now(),
                ]);

            PasswordResetToken::where('email', $user->email)->delete();
            // send email ?

            DB::commit();

            return redirect('/login')
                ->with('success', 'Utilisateur activé, vous pouvez vous connecter.');
        } catch (\Throwable $th) {
            Log::error('User '.$user->id.' not activated. '.$th->getMessage());
            DB::rollBack();

            return back()->with('error', 'Utilisateur non activé');
        }
    }
}
