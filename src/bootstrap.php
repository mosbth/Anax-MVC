<?php
/**
 * Bootstrapping functions, essential and needed for Anax to work together with some common helpers. 
 *
 */

/**
 * Default exception handler.
 *
 */
function myExceptionHandler($exception) {
  echo "Anax: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('myExceptionHandler');


/**
 * Autoloader for classes.
 *
 */
function myAutoloader($class) {
  $path = ANAX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    require($path);
  }
}
spl_autoload_register('myAutoloader');



/**
 * PR0 autoloader for classes supporting namespaces, adapted to Anax environment.
 *
 * @link http://www.php-fig.org/psr/psr-0/
 */
function autoloadPSR0($className)
{
  $path      = ANAX_INSTALL_PATH . "/src";
  $className = ltrim($className, '\\');
  $fileName  = '';
  $namespace = '';
  if ($lastNsPos = strrpos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }
  $fileName .= $path . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

  if(is_file($fileName)) {
    require $fileName;
  }
}
spl_autoload_register('autoloadPSR0');
