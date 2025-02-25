<?php

namespace App\Providers;

use App\Models\PageSection;
use App\Observers\PageSectionObserver;
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
        PageSection::observe(PageSectionObserver::class);
    }
}
