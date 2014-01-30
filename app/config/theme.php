<?php
/**
 * Config-file for Anax, theme related settings, return it all as array.
 *
 */


return [

// Language for this page.
'lang' => 'sv',

// Append this value to each <title>
'title_append' => ' | Anax en webbtemplate',

// Common header for all pages
'header' => "
<img class='sitelogo' src='img/anax.png' alt='Anax Logo'/>
<span class='sitetitle'>Anax webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
",

// Common footer for all pages
'footer' => "
<footer><span class='sitefooter'>Copyright (c) Mikael Roos (me@mikaelroos.se) | <a href='https://github.com/mosbth/Anax-MVC'>Anax-MVC på GitHub</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
",

// Stylesheets
'stylesheets' => ['css/style.css'],

// Inline style
'style' => null,

// Favicon
'favicon' => 'favicon.ico',

// Path to modernizr or null to disable
'modernizr' => 'js/modernizr.js',

// Path to jquery or null to disable
'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',

// Array with javscript-files to include
'javascript_include' => [],

// Use google analytics for tracking, set key or null to disable
'google_analytics' => null,

];
