<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment, autoloader and create your app anax-object.
include(__DIR__ . '/../app/config/environment.php'); 
include(ANAX_SOURCE_PATH . 'autoload.php'); 

$anax = Anax\Core\CAnax::instance();

$anax->config();
$anax->bootstrap();


// Do it and store it all in variables in the Anax container.
$anax->theme['title'] = "Hello World";

$anax->view['header'] = <<<EOD
<img class='sitelogo' src='img/anax.png' alt='Anax Logo'/>
<span class='sitetitle'>Anax webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;

$anax->view['main'] = <<<EOD
<h1>Hej Världen</h1>
<p>Detta är en exempelsida som visar hur Anax ser ut och fungerar.</p>
EOD;

$anax->view['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Mikael Roos (me@mikaelroos.se) | <a href='https://github.com/mosbth/Anax-base'>Anax på GitHub</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;



// Finally, leave to theme engine to render page.
$anax->render();
