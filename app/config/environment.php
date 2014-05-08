<?php
/**
 * Config-file defining essentials.
 *
 */

/**
 * Define essential Anax paths, end with /
 *
 */
define('ANAX_INSTALL_PATH', realpath(__DIR__ . '/../../') . '/');
define('ANAX_APP_PATH',     ANAX_INSTALL_PATH . 'app/');
define('ANAX_THEME_PATH', ANAX_INSTALL_PATH . 'theme');


ini_set('date.timezone', 'UTC');

date_default_timezone_set('Europe/Paris');
