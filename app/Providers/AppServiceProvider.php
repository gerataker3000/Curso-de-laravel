<?php

namespace App\Providers;

use App\Repositories\AlumnoRepository;
use App\Repositories\AlumnoRepositoryInterface;
use Illuminate\Pagination\Paginator;
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
    }
}
