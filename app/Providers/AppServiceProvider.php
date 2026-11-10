<?php

namespace App\Providers;

use App\Repositories\AlumnoRepository;
use App\Repositories\AlumnoRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios en el contenedor.
     * Cuando alguien pida la interfaz, Laravel le entrega AlumnoRepository.
     */
    public function register(): void
    {
        $this->app->bind(AlumnoRepositoryInterface::class, AlumnoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // 60 peticiones por minuto por usuario (o por IP si no hay sesión).
        RateLimiter::for('api', function (Request $request): Limit {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // 5 intentos de login por minuto por correo + IP.
        RateLimiter::for('login', function (Request $request): Limit {
            return Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip());
        });
    }
}
