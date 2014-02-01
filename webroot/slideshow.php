<?php 
/**
 * This is a Anax pagecontroller.
 *
 */



// Get environment & autoloader.
include(__DIR__.'/config.php'); 


// 
$di = new \Anax\DI\CDIFactoryDefault();
$anax = new \Anax\Kernel\CAnax($di);



// Define what to include to make the plugin to work
$anax['stylesheets'][]        = 'css/slideshow.css';
$anax['javascript_include'][] = 'js/slideshow.js';


// Do it and store it all in variables in the Anax container.
$anax->theme->setVariable('title', "Slideshow to show off how JavaScript works in Anax");

$anax->theme->setVariable('main', "
    <h1>A slideshow with JavaScript</h1>
    <p>This is a sample pagecontroller to show off how JavaScript works with Anax.</p>
");



// Finally, leave to theme engine to render page.
$anax->theme->render();
