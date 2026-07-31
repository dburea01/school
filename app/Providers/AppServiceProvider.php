<?php

namespace App\Providers;

use App\Models\School;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Implicitly grant "Admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null;
        });

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // On partage la variable $school avec TOUTES les vues Blade de l'appli
        try {
            View::share('school', School::first());
        } catch (\Throwable $e) {
            View::share('school', null);
        }

        RateLimiter::for('emails-contact', function (Request $request) {
            /** @var int $maxContactAuthorEmails */
            $maxContactAuthorEmails = config('params.max-contact-author-emails');

            return Limit::perDay($maxContactAuthorEmails)->by($request->user()?->id ?: $request->ip());
        });
    }
}
