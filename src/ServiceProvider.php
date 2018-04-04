<?php

namespace Sujan\LaraForm;

use Collective\Html\HtmlBuilder;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
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
        $this->publishes([__DIR__ . '/laraform.css' => public_path('css/laraform.css')], 'laraform');

    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $formBuilder = new FormBuilder(app(HtmlBuilder::class), app('url'), app('view'), app('session.store')->token(), app('request'));

        $this->app->singleton('laraform', function(Container $app) use ($formBuilder){
            return new LaraForm($formBuilder, $app[Parser::class]);
        });

        $this->app->alias('laraform', LaraForm::class);

        $this->registerFormBuilderMacros(app('laraform'), $formBuilder);
    }

    /**
    * Creating to form builder macros yamlToForm and jsonToForm
    *
    * @param LaraForm $laraForm
     * @param FormBuilder $formBuilder
    */
    public function registerFormBuilderMacros(LaraForm $laraForm, FormBuilder $formBuilder)
    {

        $formBuilder->macro('yaml', function($filePath) use($laraForm)
        {
            return $laraForm->yamlToForm($filePath);
        });

        $formBuilder->macro('json', function($filePath) use($laraForm)
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
