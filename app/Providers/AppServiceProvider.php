<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogAuthentication;

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
        if (request()->hasHeader('x-forwarded-proto') && request()->header('x-forwarded-proto') === 'https' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }

        // Super Admin bypass — selalu lolos semua permission check
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Catat aktivitas Login & Logout
        Event::listen(Login::class, [LogAuthentication::class, 'handleLogin']);
        Event::listen(Logout::class, [LogAuthentication::class, 'handleLogout']);

        View::composer('*', function ($view) {
            $menus = Menu::with([
                'children' => function ($query) {
                    $query->where('aktif', true)
                        ->orderBy('urutan');
                }
            ])
            ->whereNull('parent_id')
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get();

            try {
                $settings = \App\Models\Setting::pluck('value', 'key')->all();
            } catch (\Exception $e) {
                $settings = [];
            }

            $view->with('menus', $menus)->with('settings', $settings);
        });
    }
}
