# YAML, JSON to form with validation for laravel
Developing rapid forms from yaml and json, when large number of input fields will be required as well as frequent addition and deduction of fields.

## Installation
```
composer require "st8113/yaml
```

As `st8113/yaml` package is based on `laravelcollective/html` you have to add your new provider to the providers array of config/app.php:

```
'providers' => [
    // ...
    st8113\Yaml\YamlServiceProvider::class,
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
It will give you a `yaml.css` file in `/assets/css/yaml.css`

Then add `yaml.css` to your master template like 
```
<link rel="stylesheet" href="{{ asset('assets/css/yaml.css') }}">
```

## Usage
This package has multi purpose usage. You will get all the facilities of `Laravel Collective` 
as well as facilities of `st8113/yaml` package. We developed this package based on real life scenario.

#### Scenario 1
Our company decided to develop a key value store where all of our settings will reside. 
The kick here was add more and more new keys when needed but no code modification will be needed. 
Then we decided we will write our form as `yaml` or `json` and parse the them to form.

## How to Use

### Sample yaml file
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

### Sample JSON
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

Use it inside form tag in your form like 
```
{{ Form::yaml("path/to/file.yml") }}
{{ Form::json("path/to/file.json") }}
```

### Form validation
Laravel form validation. It's just a form builder.
