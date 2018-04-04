<?php namespace Sujan\LaraForm;

use Collective\Html\FormBuilder;
use Illuminate\Support\HtmlString;

/**
 * Service provider for generating Html macros
 */
class LaraForm
{
	protected $formBuilder;
    protected $yamlParser;

    /**
     * Create a new form builder instance.
     *
     * @param FormBuilder $formBuilder
     * @param \Sujan\LaraForm\Parser $yamlParser
     */
    public function __construct(FormBuilder $formBuilder, Parser $yamlParser)
    {
        $this->formBuilder = $formBuilder;
        $this->yamlParser = $yamlParser;
    }

    /**
     * Create a text input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function defaultInput($name, $field, $builder = null)
    {
        $builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label(isset($field->label) ? $field->label : '');
        $builder .= $this->formBuilder->input('text', $name, null, ['class' => 'form-control']);

        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
     * Create a user defined input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customInput($name, $field, $builder = null)
    {
        $builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label(isset($field->label) ? $field->label : '');
        $builder .= $this->formBuilder->input($field->type, $name, null, ['class' => 'form-control']);
        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
     * Create a textarea field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customTextarea($name, $field, $builder = null)
    {
        $builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label(isset($field->label) ? $field->label : '');
        $builder .= $this->formBuilder->textarea($name, $value = null, $options = ['class' => 'form-control', 'cols' => 50, 'rows' => 5]);
        $builder .= $this->getClosingTag($name); 

        return $builder;   	
    }

    /**
     * Create a checkbox input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customCheckbox($name, $field, $builder = null)
    {
    	$builder .= $this->getOpeningTag($name, $field);
        $builder .= '<label class="checkbox-inline">';
        $builder .= $this->formBuilder->checkbox($name, $value = null);
        $builder .= $field->label;
        $builder .= '</label>';

        if ($error = $this->getClosingTag($name)) {
            $builder .= '<p>'.$error.'</p>';
        } else {
            $builder .= '</div>';
        }
        
        return $builder;                   
    }

    /**
     * Create a select input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customSelect($name, $field, $builder = null)
    {
    	$builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label(isset($field->label) ? $field->label : '');
        $builder .= $this->formBuilder
            ->select($name,
                $field->options,
                $selected = null,
                ['class' => 'form-control '.get_class($field)]   
            );
        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
     * Create radio input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customRadio($name, $field, $builder = null)
    {
    	$builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label($field->label).'</br>';
        foreach ($field->options as $key => $value) {
            $builder .= $this->formBuilder
                ->radio($name, $value, $checked = null);
            $builder .= $key.'</br>';
        }
        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
     * Create a checkboxlist input field.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customCheckboxlist($name, $field, $builder = null)
    {
    	$builder .= $this->getOpeningTag($name, $field);
        $builder .= $this->formBuilder->label($field->label);
        $builder .= '<div class="field-checkboxlist">';
        foreach ($field->options as $value => $label) {
            $builder .= '<div class="checkbox custom-checkbox">';
            $builder .= $this->formBuilder
                ->checkbox($name, $value, $checked = null);
            $builder .= $label;
            $builder .= '</div>';
        }
        $builder .= '</div>';
        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
     * Create a section.
     *
     * @param  string $name
     * @param  object $field
     * @param null $builder
     * @return string
     * @internal param array $options
     */
    public function customSection($name, $field, $builder = null)
    {
        $builder .= $this->getOpeningTag($name, $field);
        $builder .= '<div class="field-section">';
        $builder .= '<h4>'.$field->label.'</h4>';
        $builder .= '</div>';
        $builder .= $this->getClosingTag($name);

        return $builder;
    }

    /**
    * Yaml to json conversion
    *
    * @param yaml file $filePath
    * @return jsonToForm
    */
    public function yamlToForm($filePath)
    {
        $data = $this->yamlParser->parseFile($filePath);

        return $this->jsonObjectToForm($data);
    }

    /**
    * To json Object
    *
    * @param json file $filePath
    * @return jsonToForm
    */
    public function jsonToForm($filePath)
    {
        $data = file_get_contents($filePath);

        return $this->jsonObjectToForm(json_decode($data));
    }

    /**
     * Transform the json object to an Html form
     *
     * @param json object $data
     * @return jsonToForm
     */
    public function jsonObjectToForm($data)
    {
        $form = '';

        foreach($data->fields as $name => $field){
            if (isset($field->type)) {
                switch($field->type){
                    case 'text':
                    case 'email':
                    case 'password':
                    case 'number':
                    case 'hidden':
                    case 'date':
                    case 'file':
                        $form .= $this->customInput($name, $field);
                    break;

                    case 'textarea':
                        $form .= $this->customTextarea($name, $field);
                    break;

                    case 'checkbox':
                        $form .= $this->customCheckbox($name, $field);
                    break;

                    case 'select':
                        $form .= $this->customSelect($name, $field);
                    break;

                    case 'radio':
                        $form .= $this->customRadio($name, $field);
                    break;

                    case 'checkboxlist':
                        $form .= $this->customCheckboxlist($name, $field);
                    break;

                    case 'section':
                        $form .= $this->customSection($name, $field);
                        break;

                    case 'partial':
                        $form .= $this->customPartial($name, $field);
                        break;

                    default:
                        break;
                }
            } else {
                $form .= $this->defaultInput($name, $field);
            }
        }

        return $this->toHtmlString($form);
    }

    /**
     * Custom input field opening tag
     * @param $name and $field
     * @param $field
     * @param string $builder
     * @return string $mixed
     */
    public function getOpeningTag($name, $field, $builder = '')
    {
        $error = $this->hasErrorMessage($name);
        $builder = '<div class="'.get_span($field).$error->class.'">';

        return $builder;
    }

    /**
     * Custom input field closing tag
     * @param $name
     * @param string $builder
     * @return string $mixed
     */
    public function getClosingTag($name, $builder = '')
    {
        $error = $this->hasErrorMessage($name);
        $builder .= $error->message;
        $builder .= '</div>';

        return $builder;
    }

    /**
    * Getting the error message and setting the error message class
    * @param $name of input field
    * @return mixed, object of error class and error message
    */
    public function hasErrorMessage($name)
    {
        $name = rtrim(str_replace(array( '[', ']' ), '.', $name), '.');

        if ($error = $this->hasErrors($name)) {
            return (object)['class' => ' has-error', 'message' => $error];
        } else {
            return (object)['class' => '', 'message' => ''];
        }
    } 

    /**
     * Determine whether the form element with the given name has any validation errors
     *
     * @param  string  $name
     * @return bool
     */
    private function hasErrors($name)
    {
        if (!session()->has('errors')) {
            return false;
        }
        
        // Get errors session
        $errors = $this->getErrorsSession();

        if ($errors->has($name)) {
            return $this->getFormattedErrors($errors, $name);
        }
    }

    /**
     * Get errors session
     *
     * @return mixed
     */
    private function getErrorsSession()
    {
        return session()->get('errors');
    }

    /**
     * Get the formatted errors for the form element with the given name
     *
     * @param  string  $name
     * @return string
     */
    private function getFormattedErrors($errors, $name)
    {
        $error = $errors->first($name);
        return '<span class="text-danger">'. $error .'</span>';
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }

}
