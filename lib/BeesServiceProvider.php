<?php

namespace Tacone\Bees;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;

class BeesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../src/views', 'bees');
//        $this->package('tacone/bees');
    }

    protected function registerFields()
    {
        $namespace = '\\Tacone\\Bees\\Field';
        $fields = ['string', 'integer', 'float', 'boolean'];
        foreach ($fields as $class) {
            App::bind("bees.$class", function ($app, $arguments) use ($class, $namespace) {
                $class = Str::studly($class);
                $reflect = new ReflectionClass($namespace."\\$class");
                $instance = $reflect->newInstanceArgs($arguments);

                return $instance;
            });
        }
    }

    /**
     * Guess the package path for the provider.
     *
     * @return string
     */
    public function guessPackagePath()
    {
        $path = (new ReflectionClass($this))->getFileName();

        return realpath(dirname($path).'/../src');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFields();
        require_once __DIR__.'/functions.php';
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
