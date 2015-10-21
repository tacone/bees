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
    }

    protected function registerFields()
    {
        $namespace = '\\Tacone\\Bees\\Field';
        $fields = ['string', 'integer', 'float', 'boolean'];
        foreach ($fields as $class) {
            App::bind("bees.$class", function ($app, $arguments) use ($class, $namespace) {
                $class = Str::studly($class).'Field';
                $reflect = new ReflectionClass($namespace."\\$class");
                $instance = $reflect->newInstanceArgs($arguments);

                return $instance;
            });
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFields();
    }
}
