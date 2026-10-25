<?php

namespace App\Providers;

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
        $whatsapp = config('moesika.whatsapp');

        // Falls back to the contact section until a WhatsApp number is configured
        $chatUrl = fn (string $message) => $whatsapp
            ? 'https://wa.me/'.$whatsapp.'?text='.rawurlencode($message)
            : '#contact';

        View::share('bookingUrl', $chatUrl("Hi Tania, I'd love to book an appointment."));
        View::share('trainingUrl', $chatUrl("Hi Tania, I'd like to know more about your lash training courses."));
    }
}
