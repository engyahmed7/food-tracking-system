<?php

namespace App\Providers;

use App\Contracts\PaymentProcessorFactoryInterface;
use App\Services\PaymentProcessorFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentProcessorFactoryInterface::class, PaymentProcessorFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
