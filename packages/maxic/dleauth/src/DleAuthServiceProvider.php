<?php namespace Maxic\DleAuth;

use Auth;
use Illuminate\Support\ServiceProvider;

class DleAuthServiceProvider extends ServiceProvider
{

    public function boot() {

        $this->publishes([
            __DIR__ . '/../config/dleconfig.php' => config_path('dleconfig.php'),
        ]);

        Auth::provider('dleauth', function($app, $config) {
            return new EloquentUserProvider($config['model']);
        });

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/dleconfig.php', 'dleconfig'
        );
    }
}