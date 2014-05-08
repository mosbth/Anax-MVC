<?php

namespace Anax\Kernel;


/**
 * My extended CAnax
 */ 
class CAnaxExtended extends \Anax\Kernel\CAnax
{
    
    public function __construct($di)
    {
        parent::__construct($di);
    }
    
    /**
     * Starts the session
     * 
     * @return void
     */ 
    public function withSession() 
    {
        $this->session = $this->di->get('session');
    }
}
