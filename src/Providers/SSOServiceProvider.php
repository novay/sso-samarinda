<?php

namespace Novay\SSO\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SSOServiceProvider extends ServiceProvider
{
    /**
     * Package tag name
     *
     * @var string
     */
    private $_packageTag = 'sso';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // 
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->mergeConfigFrom(__DIR__.'/../../config/'.$this->_packageTag.'.php', $this->_packageTag);
        $this->publishFiles();
    }

    /**
     * Publish files for SSO Client.
     *
     * @return void
     */
    private function publishFiles()
    {
        $publishTag = $this->_packageTag;

        $this->publishes([
            __DIR__.'/../../config/'.$this->_packageTag.'.php' => base_path('config/'.$this->_packageTag.'.php'),
        ], $publishTag);
    }
}