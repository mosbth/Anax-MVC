<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Anax container.
$anax['title'] = "404";
$anax['header'] = "";
$anax['main'] = "This is a Anax 404. Document is not here.";
$anax['footer'] = "";

// Send the 404 header 
header("HTTP/1.0 404 Not Found");


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
