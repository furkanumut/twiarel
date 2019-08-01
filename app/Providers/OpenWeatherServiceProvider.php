<?php

namespace App\Providers;

use Cmfcmf\OpenWeatherMap;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Weather;

class OpenWeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Cmfcmf\OpenWeatherMap', function ($app) {
            return new OpenWeatherMap(config('services.openweather.key'),
                $app->make('Http\Adapter\Guzzle6\Client'),
                $app->make('Http\Factory\Guzzle\RequestFactory'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Weather $owm)
    {
        $weather = Cache::remember('weather', 300,
            function () use ($owm) {
                return $owm->getWeather('Bolu', "metric", "tr");
            });
        \View::share('weather', $weather);
    }
}
