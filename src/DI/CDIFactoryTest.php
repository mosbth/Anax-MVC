<?php

namespace Anax\DI;

/**
 * Extended factory for Anax documentation.
 *
 */
class CDIFactoryTest extends CDIFactoryDefault
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->theme->setBaseTitle(" - Anax test case");
        $this->url->setStaticBaseUrl($this->request->getBaseUrl() . "/..");
    }
}
