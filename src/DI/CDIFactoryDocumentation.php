<?php

namespace Anax\DI;

/**
 * Extended factory for Anax documentation.
 *
 */
class CDIFactoryDocumentation extends CDIFactoryDefault
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->set('documentation', function() {
            $fc = new \Anax\Content\CFileContent();
            $fc->setBasePath(ANAX_INSTALL_PATH . 'docs/');
            return $fc;
        });
    }
}
