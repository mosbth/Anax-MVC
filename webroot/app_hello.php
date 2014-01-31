<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment, autoloader and create your app anax-object.
include(__DIR__ . '/../app/config/environment.php'); 

$di = new \Anax\DI\CDI();

$di->setShared('log', function () {
    $log = new \Anax\Logger\CLog();
    return $log;
});

$di->setShared('request',   '\Anax\Request\CRequest');
$di->setShared('response',  '\Anax\Response\CResponse');
$di->setShared('url',       '\Anax\CUrl');

$di->setShared('session', function() {
    $session = new \Anax\Session\CSession();
    $session->start();
    return $session;
});

$di->setShared('theme', function() {
    $themeEngine = new \Anax\ThemeEngine\CThemeBasic();
    $themeEngine->configure(ANAX_APP_PATH . 'config/theme.php') ;
    return $themeEngine;
});

// Bootstrap general functions
// Maybe move to static class?
// Maybe not really needed...?
include(ANAX_SOURCE_PATH . 'bootstrap.php'); 

$anax = new Anax\Kernel\CAnax($di);


// Prepare the page content
$anax->theme->setVariable('title', "Hello World");

$anax->theme->setVariable('header', "
<img class='sitelogo' src='img/anax.png' alt='Anax Logo'/>
<span class='sitetitle'>Anax webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
");

$anax->theme->setVariable('main', "
<h1>Hej Världen</h1>
<p>Detta är en exempelsida som visar hur Anax ser ut och fungerar.</p>
");

$anax->theme->setVariable('footer', "
<footer><span class='sitefooter'>Copyright (c) Mikael Roos (me@mikaelroos.se) | <a href='https://github.com/mosbth/Anax-base'>Anax på GitHub</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
");

// Finally, leave to theme engine to render page.
$anax->theme->render();
