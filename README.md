# YAML, JSON to html form with validation for laravel
Developing rapid forms from yaml and json, when large number of input fields will be required as well as frequent addition and deduction of form fields.

## Installation
```
composer require "sujan/laraform"
```

As `sujan/laraform` package is based on `laravelcollective/html` you have to add your new provider to the providers array of config/app.php:

```
'providers' => [
    // ...
    Sujan\LaraForm\YamlServiceProvider::class,
    Collective\Html\HtmlServiceProvider::class,
    // ...
],
```

Finally, add two class aliases to the aliases array of config/app.php:

```
'aliases' => [
    // ...
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,
    // ...
],
```

Then run the command
```
php artisan vendor:publish
```
It will give you a `laraform.css` file in `/css/laraform.css`

Then add `laraform.css` to your master template like 
```
<link rel="stylesheet" href="{{ asset('css/laraform.css') }}">
```

## Usage
This package has multi purpose usage. You will get all the facilities of `Laravel Collective` 
as well as facilities of `sujan/laraform` package. We developed this package based on real life scenario.

### Scenario 1
Say you have to develop a key value store where all of your application settings will reside. 
The kick here is to add more and more new keys when needed but no code modification will be needed. 
Then this is the right package for you. All you have to do is to write a yaml or json file for your form.

### Scenario 2
Let's assume the values of your settings will come as a nested object and you have to make a form for 
the object then this package is a good choice. It will build the form for you within a few minutes all 
you have to do is write the json or yaml file. 

## How to Use

Use it inside form tag in your form like 
```
{{ Form::yaml("path/to/file.yml") }}
{{ Form::json("path/to/file.json") }}
```

### Example 1
Let's say you have a `users` table and a `usersmeta` table. 
In `users` table you will save `name`,`email` and in `usersmeta` table you want to save `address`. 
Your `yaml` and `json` file will be like below. Where `usermeta` is relation name.
Our package will parse the form for you.

### Sample yaml for Example 1
```
fields:
    name:
         label: Full Name
         type: text
         span: left
           
    email:
         label: Email
         type: email
         span: right
         class: email
         
    usermeta[address]:
         label: Address
         span: full
         type: textarea
         id: address
```

### Sample JSON for Example 1
```
{
    "fields": {
        "name": {
            "label": "Full Name",
            "type": "text",
            "span": "left"
        },
        "email": {
            "label": "Email",
            "type": "email",
            "span": "right",
            "class": "email"
        },
        "usermeta": {
            "address": {
                "label": "Address",
                "span": "full",
                "type": "textarea",
                "id": "address"
             }
        }
    }
}
```

### Html form of sample YAML and JSON.
![Sample form](https://i.imgur.com/tumLaRJ.png)

### Html form of sample YAML and JSON with validation message.
![Sample form with validation](https://i.imgur.com/hELsU5d.png)

### Example 2
Our package is mainly developed for making form from json objects. 

## Sample JSON object
```
{
    "name": "Sujan Mahmud",
    "email": "sujancseruet@gmail.com",
    "usermeta": {
        "address": "Bashundhara R/A"
    }
}
```

The `yaml` and `json` file for the above object will be `#Sample 1`'s two files.

### Form validation
You have to use laravel's form validation methodology. 
The error message handling is included in the package. 
So you don't have to write code for showing error messages. 
The message will be shown below the input field marked red.
