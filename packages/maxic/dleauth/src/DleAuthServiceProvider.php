<?php namespace Maxic\DleAuth;

use Auth;
use Illuminate\Support\ServiceProvider;

class DleAuthServiceProvider extends ServiceProvider
{

    public function boot() {

        $this->publishes([
            __DIR__ . '/../config/dleauth.php' => config_path('dleauth.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/dleauth.php', 'dleauth'
        );

//        Auth::provider('dleauth', function($app)
//        {
//            $connection = $app['db']->connection();
//            $table = $app['config']['dleauth.table'];
//
//            return new DleAuthUserProvider($connection, $table);
//        });

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
    }
}