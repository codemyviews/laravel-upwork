<?php

namespace CodeMyViews\Upwork;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Upwork\API\Client;
use Upwork\API\Config;

/**
 * Upwork for PHP service provider for Laravel applications
 */
class UpworkServiceProvider extends ServiceProvider
{
    const VERSION = '0.0.1';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__).'/config/upwork.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('upwork.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('upwork');
        }

        $this->mergeConfigFrom($source, 'upwork');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('upwork', function ($app) {
            $config = $app->make('config')->get('upwork');
            return new Client(new Config([
                'consumerKey'       => $config->consumerKey,  // SETUP YOUR CONSUMER KEY
                'consumerSecret'    => $config->secret,                // SETUP KEY SECRET
                'accessToken'       => '',       // got access token
                'accessSecret'      => '',      // got access secret
                'debug'             => $config->debug,                  // enables debug mode
            ]));
        });

        $this->app->alias('upwork', 'Upwork\API\Client');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['upwork', 'Upwork\API\Client'];
    }

}