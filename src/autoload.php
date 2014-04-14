<?php
/**
 * Autoloader for Anax environment, including composer autoloader, if available.
 *
 */

/**
 * Autoloader for classes using Anax-base names.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {
    $path = ANAX_SOURCE_PATH . "/{$class}/{$class}.php";
    if(is_file($path)) {
        require($path);
    }
});



// Maybe just use the CLoader-class and put loader code into it?



/**
 * PSR-0 autoloader for classes supporting namespaces, adapted to Anax environment.
 *
 * @link http://www.php-fig.org/psr/psr-0/
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($className) {

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
 * PSR-4 autoloader for Anax environment.
 *
 * @link http://www.php-fig.org/psr/psr-4/
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Anax\\';

    // base directory for the namespace prefix
    $base_dir = ANAX_SOURCE_PATH;

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . '/' . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});


