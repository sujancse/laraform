<?php

namespace Sujan\LaraForm;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Form;
use Collective\Html\FormBuilder;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/yaml.css' => public_path('css/yaml.css')], 'public');

    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laraform', function(Container $app){
            return new LaraForm($app[FormBuilder::class], $app[Parser::class]);
        });

        $this->app->alias('laraform', LaraForm::class);

        $this->registerFormBuilderMacros();
    }

    /**
    * Creating to form builder macros yamlToForm and jsonToForm
    *
    * @param $yamlFormBuilder
    */
    public function registerFormBuilderMacros()
    {
        $laraForm = app('laraform');

        Form::macro('yaml', function($filePath) use($laraForm)
        {
            return $laraForm->yamlToForm($filePath);
        });

        Form::macro('json', function($filePath) use($laraForm)
        {
            return $laraForm->jsonToForm($filePath);
        });
    }

    public function provides()
    {
        return [
            'laraform'
        ];
    }
}
