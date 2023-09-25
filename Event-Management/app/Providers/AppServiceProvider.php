<?php

namespace App\Providers;

use App\Models\Attendee;
use App\Services\OrderResponseService;
use App\Services\PurchaseService;
use App\Services\TicketValidator;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Cashier::ignoreMigrations();

        $this->app->bind(TicketValidator::class, function () {
            return new TicketValidator();
        });

        $this->app->singleton(PurchaseService::class, function () {
            return new PurchaseService();
        });

        $this->app->singleton(OrderResponseService::class, function () {
            return new OrderResponseService();
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Attendee::class);
    }
}
