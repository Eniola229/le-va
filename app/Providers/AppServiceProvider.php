<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;         
use App\Services\BrevoMailService;
use App\Services\CloudinaryService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BrevoMailService::class);
        $this->app->singleton(CloudinaryService::class);
    }

    public function boot(): void
    {
        Paginator::defaultView('components.pagination');
    }
}