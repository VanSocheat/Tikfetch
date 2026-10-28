<?php

namespace App\Providers;

use App\Contracts\TikTokVideoProviderInterface;
use App\Services\DemoTikTokVideoProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TikTokVideoProviderInterface::class, function () {
            // Intentionally fail closed until a real provider adapter is implemented.
            return new DemoTikTokVideoProvider();
        });
    }

    public function boot(): void
    {
        //
    }
}
