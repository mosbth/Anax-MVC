<?php

namespace Anax\Language;

/**
 * A simple multi-language class
 * 
 * @author Jonatan Karlsson
 * @license MIT
 * @version 1.0.2
 *
 */
class Language implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    protected $lang;
    protected $saveType;
    protected $options;

    /**
     * 
     * @param array $options
     * @param string $saveType 
     */
    public function __construct($options, $saveType = 'session')
    {
        $this->options = $options;

        $this->saveType = $saveType;
        $this->setLang($this->options['default']['lang']);
    }

    /**
     * Gets the paths based on $key
     *
     * @param  $key
     *
     * @return String based on $key
     */
    public function get($key, $isArray = false) 
    {
        $var = $this->options['paths'][$key];
        if (isset($var)) {
            $var = str_replace('$1', $this->getLang(), $var);
            if ($isArray) {
                return require $var;
            } else {                
                return file_get_contents($var);
            }
        } 
        return $this->getDefault($key);
    }

    /**
     * Gets the language sat
     * 
     * @return $lang
     */
    public function getLang() 
    {
        if ($this->saveType != 'session') {
            return $this->lang;
        }
        return $_SESSION['lang']; 
    }

    /**
     * Sets the language
     * 
     * @param string $lang
     */
    public function setLang($lang)
    {        
        if ($this->saveType != 'session') {
            $this->lang = $lang;
        } else {
            $_SESSION['lang'] = $lang;
        }
    } 

    /**
     * Gets the default value based on $key
     *
     * @param  $key
     *
     * @return String based on $key
     */
    public function getDefault($key)
    {
        if (isset($key, $this->options)) {
            return file_get_contents($this->options['default'][$key]);
        } else {
            throw new \Exception("Didn't find {$key}");
        } 
    }

    /**
     * Gets the navbar
     * 
     * @return Array with for the navbar configure
     */
    public function getNavbar($key = null)
    {
        if ($key !== null) {
            if (isset($this->options['paths'][$key])) {
                $var = $this->options['paths'][$key];
                // get the default key
                $default = $this->navbarStructure();
                // gets the navbar items
                $var = str_replace('$1', $this->getLang(), $var);
                $nav = require $var;
               
                $default['items'] = $nav['items'];

                return $default;
            }
        }
        return false;
    }

    public function navbarStructure() 
    {
        return require ANAX_APP_PATH . 'config/navbar.php';
    }

    /**
     *  Gets meta name content
     * 
     *  @param $key the meta name
     *
     *  @return Content based on $key
     */
    public function getMeta($key, $lang = null) 
    {
        if (isset($this->options['meta'][$this->getLang()][$key])) {
            return $this->options['meta'][$this->getLang()][$key];
        } else if (isset($this->options['meta'][$lang][$key])) {
            return $this->options['meta'][$lang][$key];
        }
        return $this->options['default'][$key];   
    }
}
