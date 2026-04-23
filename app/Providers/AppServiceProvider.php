<?php

namespace App\Providers;

use App\Services\TenantManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TenantManager::class);
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
    }
}
