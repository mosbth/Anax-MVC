<?php

namespace Mos\HTMLForm;

/**
 * Form element 
 */
class CFormElementUrl extends CFormElement
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
        $this['type'] = 'url';
        $this->UseNameAsDefaultLabel();
    }
}
