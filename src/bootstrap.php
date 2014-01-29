<?php
/**
 * Bootstrapping functions, essential and needed for Anax to work together with some common helpers. 
 *
 */

/**
 * Default exception handler.
 *
 */
set_exception_handler ( function ($exception) {
  echo "Anax: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
});



/**
 * Autoloader for classes using Anax-base names.
 *
 */
spl_autoload_register ( function ($class) {
  $path = ANAX_SOURCE_PATH . "/{$class}/{$class}.php";
  if(is_file($path)) {
    require($path);
  }
});



/**
 * PSR-0 & PSR-4 autoloader for classes supporting namespaces, adapted to Anax environment.
 *
 * @link http://www.php-fig.org/psr/psr-0/
 * @link http://www.php-fig.org/psr/psr-4/
 */
spl_autoload_register ( function ($className) {
  $path      = ANAX_SOURCE_PATH . DIRECTORY_SEPARATOR;
  $className = ltrim($className, '\\');
  $fileName  = $path;
  $namespace = '';
  if ($lastNsPos = strrpos($className, '\\')) {
    $namespace  = substr($className, 0, $lastNsPos);
    $className  = substr($className, $lastNsPos + 1);
    $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }
  $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

  if(is_file($fileName)) {
    require $fileName;
  }
});



/**
 * Including composer autoloader if available.
 *
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
if(is_file(ANAX_VENDOR_PATH . '/autoload.php')) {
  require(ANAX_VENDOR_PATH . '/autoload.php');
}



/**
 * Utility for debugging.
 *
 */
function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}
