<?php

namespace st8113\Yaml;

use Illuminate\Support\ServiceProvider;
use Form;

class YamlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/yaml.css' => public_path('assets/css/yaml.css')], 'public');
        $this->app->call([$this, 'registerFormBuilderMacros']);
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('yaml', function(){
            return new Yaml();
        });
    }

    /**
    * Creating to form builder macros yamlToForm and jsonToForm
    *
    * @param $yamlFormBuilder
    */
    public function registerFormBuilderMacros(YamlFormBuilder $yamlFormBuilder)
    {
        Form::macro('yaml', function($filePath) use($yamlFormBuilder)
        {
            return $yamlFormBuilder->yamlToForm($filePath);
        });

        Form::macro('json', function($filePath) use($yamlFormBuilder)
        {
            return $yamlFormBuilder->jsonToForm($filePath);
        });
    }
}
