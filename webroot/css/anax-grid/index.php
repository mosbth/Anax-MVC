<?php
// Just to create the proper link to source.php
$self = $_SERVER['PHP_SELF']; $selfurl = 'http://dbwebb.se'.$self; $dirs=explode( '/', trim(__DIR__, '/')); $dir=end($dirs);

?><!DOCTYPE html>
<head>
  <meta charset=utf-8>
  <title>Autocompiling LESS to CSS using lessphp</title>
  <link rel='stylesheet' type='text/css' href='style.php' />
</head>
<body>

<div class='content'>

<h1>Autocompiling LESS to CSS using lessphp</h1>
<p>So, you want to use <a href='http://lesscss.org/'>LESS</a> with automatic serverside compiling using <a href='http://leafo.net/lessphp/'>lessphp</a>?</p>

<h2>Step 1: Create the LESS stylesheet</h2>
<p><a href='http://dbwebb.se/kod-exempel/source.php?dir=lessphp&file=style.less'>This is a sample stylesheet</a>, I name it <code>style.less</code> as you see.

<h2>Step 2: Download and install lessphp</h2>
<p>I download the compiler, <a href='http://leafo.net/lessphp/'>lessphp</a>, from <a href='https://github.com/leafo/lessphp'>its GitHub repository</a>.</p>

<p><code>git clone git://github.com/leafo/lessphp.git</code></p>

<p><a href='http://dbwebb.se/kod-exempel/source.php?dir=lessphp/lessphp'>Here are the sources for lessphp in my sample installation</a>.</p>

<h2>Step 3: Create a <code>style.php</code> to make CSS from LESS</h2>
<p>Now I need some PHP-code to feed <code>lessphp</code> with my <code>style.less</code>. I put everything together in <code>style.php</code>.</p>
<p>You can try it out by just accessing it, <a href='style.php'>style.php</a>, it should present the final CSS-code.<p>
<p>Review the sourcecode for <a href='http://dbwebb.se/kod-exempel/source.php?dir=lessphp&file=style.php#file'><code>style.php</code></a>.</p>
<p>Do not forget to make the directory writable for the webserver, <code>lessphp</code> needs to be able to write the cache-file and the resulting css-file.</p>

<h2>Step 4: Add stylesheet to the webpage</h2>
<p>Just add the "stylesheet", <code>style.php</code>, as any normal stylesheet to your webpage.</p>
<p><code><?=htmlentities("<link rel='stylesheet' type='text/css' href='style.php' />")?></code></p>
<p>When you are done with development, and want to make it a production environment, just change the stylesheet, change <code>.php</code> to <code>.css</code>.</p>
<p><code><?=htmlentities("<link rel='stylesheet' type='text/css' href='style.css' />")?></code></p>

<h2>Done!</h2>
<p>Have fun and review the <a href="../source.php?dir=<?=$dir?>">sourcecode for this example</a> to review how its working.</p>
<p>Or <a href='https://github.com/mosbth/stylephp'>clone the whole example</a>, including lessphp essentials, from GitHub.</p>
<p><a href='http://dbwebb.se/f/1489'>Discuss this example in the forum</a>.</p>

<p class=footer>
Example made by Mikael Roos, me@mikaelroos.se, last updated 2013-10-28.<br/><br/>
  <a href="http://validator.w3.org/check/referer">HTML5</a>  
  <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
  <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS3</a>
  <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>
  <a href="http://validator.w3.org/i18n-checker?docAddr=<?=$selfurl?>">i18n</a>
  <a href="http://dbwebb.se/kod-exempel/source.php?dir=<?=$dir?>&amp;file=<?=basename($self)?>#file">Sourcecode</a>
</p>

</div>
<script>var _gaq=[['_setAccount','UA-22093351-1'],['_trackPageview']];(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src='//www.google-analytics.com/ga.js';s.parentNode.insertBefore(g,s)}(document,'script'))</script>
</body>
</html>
