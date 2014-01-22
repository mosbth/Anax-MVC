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
  $path = ANAX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    require($path);
  }
});



/**
 * PR0 autoloader for classes supporting namespaces, adapted to Anax environment.
 *
 * @link http://www.php-fig.org/psr/psr-0/
 */
spl_autoload_register ( function ($className) {
  $path      = ANAX_INSTALL_PATH . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR;
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
