<?php

namespace App\Providers;

use App\Services\EshopService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $handlers = $this->getHandlers();

        $this->app->bind(EshopService::class, function ($app) use ($handlers) {
            return new EshopService($handlers);
        });
    }

    protected function getHandlers()
    {
        $handlerPath = app_path('Handlers/Eshop');

        $handlers = [];

        foreach (File::allFiles($handlerPath) as $file) {
            $namespace = 'App\\Handlers\\Eshop\\';
            $class = $namespace . $file->getBasename('.php');
            $handlers[] = $class;
        }

        return $handlers;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
