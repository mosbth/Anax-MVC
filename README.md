Anax-MVC
=========

[![Latest Stable Version](https://poser.pugx.org/leaphly/cart-bundle/version.png)](https://packagist.org/packages/anax/mvc)
[![Build Status](https://travis-ci.org/sebastianbergmann/phpunit.png?branch=master)](https://travis-ci.org/mos/anax-mvc)
[![License](https://poser.pugx.org/leaphly/cart-bundle/license.png)](https://packagist.org/packages/leaphly/cart-bundle)

A PHP-MVC-micro framework / webbtemplate / boilerplate for smaller websites and webbapplications using PHP.

Builds upon Anax-base, read article about Anax-base here: http://dbwebb.se/kunskap/anax-en-hallbar-struktur-for-dina-webbapplikationer



License 
------------------

By Mikael Roos.

This software is free software and carries a MIT license.



Use of external libraries
-----------------------------------

The following external modules are included and subject to its own license.



### Modernizr
* Website: http://modernizr.com/
* Version: 2.6.2
* License: MIT license 
* Path: included in `webroot/js/modernizr.js`



History
-----------------------------------


x.x.x (latest) (Anax-MVC)

* Cloned Anax-MVC and preparing to build Anax-MVC.
* Added autoloader for PSR-0.
* Not throwing exception in standard anax autoloader.
* Using anonomous functions in `bootstrap.php` to set up exception handler and autoloader.
* Added `$anax['style']` as inline style in `config.php` and `index.tpl.php`.


###History for Anax-base

v1.0.3 (2013-11-22)

* Naming of session in `webroot/config.php` allows only alphanumeric characters.


v1.0.2 (2013-09-23)

* Needs to define the ANAX_INSTALL path before using it. v1.0.1 did not work.


v1.0.1 (2013-09-19)

* `config.php`, including `bootstrap.php` before starting session, needs the autoloader()`.


v1.0.0 (2013-06-28)

* First release after initial article on Anax.



```
 .  
..:  Copyright (c) 2013 - 2014 Mikael Roos, me@mikaelroos.se
```


