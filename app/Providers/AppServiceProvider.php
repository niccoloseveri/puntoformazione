<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        \Filament\Http\Responses\Auth\LoginResponse::class => \App\Http\Responses\LoginResponse::class,
        \Filament\Http\Responses\Auth\LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];
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
        Number::useLocale('it');
        /*FilamentAsset::register([
            Js::make('mobile-sidebar', '<script>
            document.addEventListener("DOMContentLoaded", () => {
                Alpine.store("mobileSidebar", {
                isClosed: Alpine.$persist(false).as("isClosed"),
                close() {
                    this.isClosed = true;
                },
                });

                const filamentSidebarCloseOverlay = document.querySelector(".filament-sidebar-close-overlay");

                if (! Alpine.store("mobileSidebar").isClosed && filamentSidebarCloseOverlay) {
                if (window.innerWidth <= 768) {
                    filamentSidebarCloseOverlay.click();
                    Alpine.store("mobileSidebar").close();
                }
                }
            });
            </script>'),
        ]);*/
    }
}
