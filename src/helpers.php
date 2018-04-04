<?php

if(!function_exists('yaml')){
    function yaml(){
        return app('yaml');
    }
}

if(!function_exists('get_yaml')){
    function get_yaml($file){
        return base_path('/resources/views/yaml/').$file;
    }
}

if(!function_exists('get_json')){
    function get_json($file){
        return base_path('/resources/views/json/').$file;
    }
}

if(!function_exists('get_span')){
    function get_span($field){
        return isset($field->span) ? 'span-'.$field->span : 'span-full';
    }
}


