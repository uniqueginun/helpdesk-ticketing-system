<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Repo\TicketRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TicketRepository::class, function () {
            return new TicketRepository(Ticket::query());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
