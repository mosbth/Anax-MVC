<?php

namespace Mos\HTMLForm;

/**
 * Form element 
 */
class CFormElementCheckbox extends CFormElement
{

    /**
     * Constructor
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty array.
     *
     * @return void
     */
    public function __construct($name, $attributes = []) 
    {
        parent::__construct($name, $attributes);
        $this['type']     = 'checkbox';
        $this['checked']  = isset($attributes['checked']) ? $attributes['checked'] : false;
        $this['value']    = isset($attributes['value']) ? $attributes['value'] : $name;
        $this->UseNameAsDefaultLabel(null);
    }
}

