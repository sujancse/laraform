<?php

namespace Sujan\LaraForm;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Form;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/laraform.css' => public_path('css/laraform.css')], 'laraform');
        $this->app->call([$this, 'registerFormBuilderMacros']);
    }

    /**
     * Creating to form builder macros yamlToForm and jsonToForm
     *
     * @param LaraForm $laraForm
     */
    public function registerFormBuilderMacros(LaraForm $laraForm)
    {
        Form::macro('yaml', function($filePath) use($laraForm)
        {
            return $laraForm->yamlToForm($filePath);
        });

        Form::macro('json', function($filePath) use($laraForm)
        {
            return $laraForm->jsonToForm($filePath);
        });
    }
}
