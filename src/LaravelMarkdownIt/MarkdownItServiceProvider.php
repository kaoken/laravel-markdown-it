<?php
/**
 * Copyright (c) 2017 kaoken
 *
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
namespace Kaoken\LaravelMarkdownIt;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as FoundationApplication;
use Laravel\Lumen\Application as LumenApplication;



class MarkdownItServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

    }

    /**
     * app/config/markdownit.php
     */
    protected function setupConfig()
    {
        $path = config_path('/markdownit.php');

        if ( $this->app instanceof FoundationApplication && $this->app->runningInConsole() && !file_exists($path) ) {
            $srcPath=__DIR__.'/../Config/markdownit.stub';
            $this->publishes([$srcPath => $path]);
        } else if ($this->app instanceof LumenApplication) {
            $this->app->configure('markdownit');
        }

        $this->mergeConfigFrom($path, 'markdownit');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('markdownit', function ($app) {
            return new MarkdownItManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'markdownit'
        ];
    }
}
