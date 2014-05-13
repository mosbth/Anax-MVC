<?php

namespace Mos\HTMLForm;

/**
 * A utility class to easy creating and handling of forms
 * 
 * @package CForm
 */
class CForm implements \ArrayAccess
{

    /**
     * Properties
     */
    public $form;     // array with settings for the form
    public $elements; // array with all form elements
    public $output;   // array with messages to display together with the form


    /**
     * Constructor
     *
     * @param array $form     details for the form
     * @param array $elements all the elements
     */
    public function __construct($form = [], $elements = [])
    {
        $this->create($form, $elements);
    }



    /**
     * Implementing ArrayAccess for this->elements
     */
    public function offsetSet($offset, $value) { if (is_null($offset)) { $this->elements[] = $value; } else { $this->elements[$offset] = $value; }}
    public function offsetExists($offset) { return isset($this->elements[$offset]); }
    public function offsetUnset($offset) { unset($this->elements[$offset]); }
    public function offsetGet($offset) { return isset($this->elements[$offset]) ? $this->elements[$offset] : null; }



    /**
     * Add a form element
     *
     * @param array $form     details for the form
     * @param array $elements all the elements
     *
     * @return $this CForm
     */
    public function create($form = [], $elements = [])
    {
        $this->form = $form;
        if (!empty($elements)) {
            foreach ($elements as $key => $element) {
                $this->elements[$key] = CFormElement::Create($key, $element);
            }
        }
        $this->output = [];

        return $this;
    }
  


    /**
     * Add a form element
     *
     * @param CFormElement $element the formelement to add.
     *
     * @return $this CForm
     */
    public function addElement($element)
    {
        $this[$element['name']] = $element;
        return $this;
    }
  


    /**
     * Remove an form element
     *
     * @param string $name the name of the element to remove from the form.
     *
     * @return $this CForm
     */
    public function removeElement($name)
    {
        unset($this->elements[$name]);
        return $this;
    }
  


    /**
     * Set validation to a form element
     *
     * @param string $element the name of the formelement to add validation rules to.
     * @param array  $rules   array of validation rules.
     *
     * @return $this CForm
     */
    public function setValidation($element, $rules)
    {
        $this[$element]['validation'] = $rules;
        return $this;
    }
  


    /**
     * Add output to display to the user what happened whith the form.
     *
     * @param string $str the string to add as output.
     *
     * @return $this CForm.
     */
    public function addOutput($str)
    {
        if (isset($_SESSION['form-output'])) {
            $_SESSION['form-output'] .= " $str";
        } else {
            $_SESSION['form-output'] = $str;
        }
        return $this;
    }



    /**
     * Get value of a form element
     *
     * @param string $element the name of the formelement.
     *
     * @return mixed the value of the element.
     */
    public function value($element)
    {
        return $this[$element]['value'];
    }
  


    /**
     * Return HTML for the form or the formdefinition.
     *
     * @param array $options with options affecting the form output.
     *
     * @return string with HTML for the form.
     */
    public function getHTML($options = [])
    {
        $defaults = [
            'start'          => false,  // Only return the start of the form element
            'columns'        => 1,      // Layout all elements in one column
            'use_buttonbar'  => true,   // Layout consequtive buttons as one element wrapped in <p>
            'use_fieldset'   => true,   // Wrap form fields within <fieldset>
            'legend'         => isset($this->form['legend']) ? $this->form['legend'] : null,   // Use legend for fieldset
        ];
        $options = array_merge($defaults, $options);

        $form = array_merge($this->form, $options);
        $id     = isset($form['id'])      ? " id='{$form['id']}'" : null;
        $class  = isset($form['class'])   ? " class='{$form['class']}'" : null;
        $name   = isset($form['name'])    ? " name='{$form['name']}'" : null;
        $action = isset($form['action'])  ? " action='{$form['action']}'" : null;
        $method = isset($form['method'])  ? " method='{$form['method']}'" : " method='post'";

        if ($options['start']) {
            return "<form{$id}{$class}{$name}{$action}{$method}>\n";
        }

        $fieldsetStart  = '<fieldset>';
        $legend         = null;
        $fieldsetEnd    = '</fieldset>';
        if (!$options['use_fieldset']) {
            $fieldsetStart = $fieldsetEnd = null;
        }

        if ($options['use_fieldset'] && $options['legend']) {
            $legend = "<legend>{$options['legend']}</legend>";
        }

        $elementsArray  = $this->GetHTMLForElements($options);
        $elements       = $this->GetHTMLLayoutForElements($elementsArray, $options);
        $output         = $this->GetOutput();
        
        $html = <<< EOD
\n<form{$id}{$class}{$name}{$action}{$method}>
{$fieldsetStart}
{$legend}
{$elements}
{$output}
{$fieldsetEnd}
</form>\n
EOD;
        
        return $html;
    }
 


    /**
     * Return HTML for the elements
     *
     * @param array $options with options affecting the form output.
     *
     * @return array with HTML for the formelements.
     */
    public function getHTMLForElements($options = [])
    {
        $defaults = [
            'use_buttonbar' => true,
        ];
        $options = array_merge($defaults, $options);

        $elements = array();
        reset($this->elements);
        while (list($key, $element) = each($this->elements)) {
      
            if (in_array($element['type'], array('submit', 'reset', 'button'))
                && $options['use_buttonbar']
            ) {

                // Create a buttonbar
                $name = 'buttonbar';
                $html = "<p class='buttonbar'>\n" . $element->GetHTML() . '&nbsp;';

                // Get all following submits (and buttons)
                while (list($key, $element) = each($this->elements)) {
                    if (in_array($element['type'], array('submit', 'reset', 'button'))) {
                        $html .= $element->GetHTML();
                    } else {
                        prev($this->elements);
                        break;
                    }
                }
                $html .= "\n</p>";

            } else {
    
                // Just add the element
                $name = $element['name'];
                $html = $element->GetHTML();
            }

            $elements[] = array('name'=>$name, 'html'=> $html);
        }

        return $elements;
    }

  


    /**
     * Place the elements according to a layout and return the HTML
     *
     * @param array $elements as returned from GetHTMLForElements().
     * @param array $options  with options affecting the layout.
     *
     * @return array with HTML for the formelements.
     */
    public function getHTMLLayoutForElements($elements, $options=array())
    {
        $defaults = [
            'columns' => 1,
            'wrap_at_element' => false,  // Wraps column in equal size or at the set number of elements
        ];
        $options = array_merge($defaults, $options);

        $html = null;
        if ($options['columns'] === 1) {
        
            foreach ($elements as $element) {
                $html .= $element['html'];
            }
        
        } else if ($options['columns'] === 2) {
        
            $buttonbar = null;
            $col1 = null;
            $col2 = null;
          
            $e = end($elements);
            if ($e['name'] == 'buttonbar') {
                $e = array_pop($elements);
                $buttonbar = "<div class='cform-buttonbar'>\n{$e['html']}</div>\n";
            }

            $size = count($elements);
            $wrapAt = $options['wrap_at_element'] ? $options['wrap_at_element'] : round($size/2);
            for ($i=0; $i<$size; $i++) {
                if ($i < $wrapAt) {
                    $col1 .= $elements[$i]['html'];
                } else {
                    $col2 .= $elements[$i]['html'];
                }
            }

            $html = "<div class='cform-columns-2'>\n<div class='cform-column-1'>\n{$col1}\n</div>\n<div class='cform-column-2'>\n{$col2}\n</div>\n{$buttonbar}</div>\n";
        }

        return $html;
    }
  


    /**
     * Get an array with all elements that failed validation together with their id and validation message.
     *
     * @return array with elements that failed validation.
     */
    public function getValidationErrors()
    {
        $errors = [];
        foreach ($this->elements as $name => $element) {
            if ($element['validation-pass'] === false) {
                $errors[$name] = [
                    'id' => $element->GetElementId(),
                    'label' => $element['label'], 
                    'message' => implode(' ', $element['validation-messages'])
                ];
            }
        }
        return $errors;
    }



    /**
     * Get output messages as <output>.
     *
     * @return string/null with the complete <output> element or null if no output.
     */
    public function getOutput()
    {
        return !empty($this->output)
            ? "<output>{$this->output}</output>"
            : null;
    }



    /**
     * Init all element with values from session, clear all and fill in with values from the session.
     *
     * @param array $values retrieved from session
     *
     * @return void
     */
    protected function initElements($values)
    {
        // First clear all
        foreach ($this->elements as $key => $val) {
            // Do not reset value for buttons
            if (in_array($this[$key]['type'], array('submit', 'reset', 'button'))) {
                continue;
            }

            // Reset the value
            $this[$key]['value'] = null;

            // Checkboxes must be cleared
            if (isset($this[$key]['checked'])) {
                $this[$key]['checked'] = false;
            }
        }

        // Now build up all values from $values (session)
        foreach ($values as $key => $val) {

            // Take care of arrays as values (multiple-checkbox)
            if (isset($val['values'])) {
                $this[$key]['checked'] = $val['values'];
                //$this[$key]['values']  = $val['values'];
            } else {
                $this[$key]['value'] = $val['value'];
            }

            if ($this[$key]['type'] === 'checkbox') {
                $this[$key]['checked'] = true;
            } else if ($this[$key]['type'] === 'radio') {
                $this[$key]['checked'] = $val['value'];
            }

            // Keep track on validation messages if set
            if (isset($val['validation-messages'])) {
                $this[$key]['validation-messages'] = $val['validation-messages'];
                $this[$key]['validation-pass'] = false;
            }
        }
    }



    /**
     * Check if a form was submitted and perform validation and call callbacks.
     * The form is stored in the session if validation or callback fails. The page should then be redirected
     * to the original form page, the form will populate from the session and should be rendered again.
     * Form elements may remember their value if 'remember' is set and true.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     *
     * @return mixed, $callbackStatus if submitted&validates, false if not validate, null if not submitted. 
     *         If submitted the callback function will return the actual value which should be true or false.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        $remember = null;
        $validates = null;
        $callbackStatus = null;
        $values = array();
    
        // Remember output messages in session
        if (isset($_SESSION['form-output'])) {
            $this->output = $_SESSION['form-output'];
            unset($_SESSION['form-output']);
        }

        $request = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = $_POST;
            unset($_SESSION['form-failed']);
            $validates = true;

            foreach ($this->elements as $element) {

                // The form element has a value set
                if (isset($request[$element['name']])) {

                    // Multiple choices comes in the form of an array
                    if (is_array($request[$element['name']])) {
                        $values[$element['name']]['values'] = $element['checked'] = $request[$element['name']];
                    } else {
                        $values[$element['name']]['value'] = $element['value'] = $request[$element['name']];
                    }

                    // If the element is a checkbox, set its value of checked.
                    if ($element['type'] === 'checkbox') {
                        $element['checked'] = true;
                    }

                    // If the element is a radio, set the value to checked.
                    if ($element['type'] === 'radio') {
                        $element['checked'] = $element['value'];
                    }

                    // Do validation of form element
                    if (isset($element['validation'])) {
                    
                        $element['validation-pass'] = $element->Validate($element['validation'], $this);
                    
                        if ($element['validation-pass'] === false) {
                    
                            $values[$element['name']] = [
                                'value'=>$element['value'],
                                'validation-messages' => $element['validation-messages']
                            ];
                            $validates = false;
                    
                        }
                    }

                    // Hmmm.... Why did I need this remember thing?
                    if (isset($element['remember'])
                        && $element['remember']
                    ) {
                        $values[$element['name']] = ['value'=>$element['value']];
                        $remember = true;
                    }

                    // Carry out the callback if the form element validates
                    if (isset($element['callback'])
                        && $validates
                    ) {
                
                        if (isset($element['callback-args'])) {
                
                            $callbackStatus = call_user_func_array($element['callback'], array_merge(array($this), $element['callback-args']));
                
                        } else {
                
                            $callbackStatus = call_user_func($element['callback'], $this);
                        }
                    }

                } else {

                    // The form element has no value set
                    
                    // Set element to null, then we know it was not set.
                    //$element['value'] = null;
                    //echo $element['type'] . ':' . $element['name'] . ':' . $element['value'] . '<br>';

                    // If the element is a checkbox, clear its value of checked.
                    if ($element['type'] === 'checkbox'
                        || $element['type'] === 'checkbox-multiple'
                    ) {
                        
                        $element['checked'] = false;
                    }

                    // Do validation even when the form element is not set? Duplicate code, revise this section and move outside this if-statement?
                    if (isset($element['validation'])) {
                        
                        $element['validation-pass'] = $element->Validate($element['validation'], $this);
                        
                        if ($element['validation-pass'] === false) {
                        
                            $values[$element['name']] = array('value'=>$element['value'], 'validation-messages'=>$element['validation-messages']);
                            $validates = false;
                        }
                    }
                }
            }
        } elseif (isset($_SESSION['form-failed'])) {
    
            // Read form data from session if the previous post failed during validation.
            $this->InitElements($_SESSION['form-failed']);
            unset($_SESSION['form-failed']);

        } elseif (isset($_SESSION['form-remember'])) {

            // Read form data from session if some form elements should be remembered
            foreach ($_SESSION['form-remember'] as $key => $val) {
                $this[$key]['value'] = $val['value'];
            }
            unset($_SESSION['form-remember']);

        } elseif (isset($_SESSION['form-save'])) {
            
            // Read form data from session,
            // useful during test where the original form is displayed with its posted values
            $this->InitElements($_SESSION['form-save']);
            unset($_SESSION['form-save']);
        }
    
    
        // Prepare if data should be stored in the session during redirects
        // Did form validation or the callback fail?
        if ($validates === false
            || $callbackStatus === false
        ) {

            $_SESSION['form-failed'] = $values;

        } elseif ($remember) {

            // Hmmm, why do I want to use this
            $_SESSION['form-remember'] = $values;
        }
    
        if (isset($this->saveInSession) && $this->saveInSession) {

            // Remember all posted values
            $_SESSION['form-save'] = $values;
        }

        // Lets se what the returnvalue should be
        $ret = $validates
            ? $callbackStatus
            : $validates;


        if ($ret === true && isset($callIfSuccess)) {

            // Use callback for success, if defined
            if (is_callable($callIfSuccess)) {
                call_user_func_array($callIfSuccess, [$this]);
            } else {
                throw new \Exception("CForm, success-method is not callable.");
            }
    
        } elseif ($ret === false && isset($callIfSuccess)) {
    
            // Use callback for fail, if defined
            if (is_callable($callIfSuccess)) {
                call_user_func_array($callIfSuccess, [$this]);
            } else {
                throw new \Exception("CForm, success-method is not callable.");
            }
        }

        return $ret;
    }
}
