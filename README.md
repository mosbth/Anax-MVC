Anax-MVC
=========

[![Latest Stable Version](https://poser.pugx.org/leaphly/cart-bundle/version.png)](https://packagist.org/packages/anax/mvc)
[![Build Status](https://travis-ci.org/mosbth/Anax-MVC.png?branch=master)](https://travis-ci.org/mosbth/Anax-MVC)
[![Code Coverage](https://scrutinizer-ci.com/g/mosbth/Anax-MVC/badges/coverage.png?s=f999ab1961684a91050b095682f7ab7a13ccb534)](https://scrutinizer-ci.com/g/mosbth/Anax-MVC/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/mosbth/Anax-MVC/badges/quality-score.png?s=1c2fc1af0df7fb7ee1e4f379a81253583a750297)](https://scrutinizer-ci.com/g/mosbth/Anax-MVC/)

A PHP-based and MVC-inspired (micro) framework / webbtemplate / boilerplate for websites and webbapplications.

Read article about it here: ["Anax som MVC-ramverk"](http://dbwebb.se/kunskap/anax-som-mvc-ramverk) and here ["Bygg en me-sida med Anax-MVC"](http://dbwebb.se/kunskap/bygg-en-me-sida-med-anax-mvc).

Builds upon Anax-base, read article about Anax-base ["Anax - en hållbar struktur för dina webbapplikationer"](http://dbwebb.se/kunskap/anax-en-hallbar-struktur-for-dina-webbapplikationer) to get an overview of its none-MVC variant.

By Mikael Roos, me@mikaelroos.se.



License
------------------

This software is free software and carries a MIT license.



Use of external libraries
-----------------------------------

The following external modules are included and subject to its own license.



### Modernizr
* Website: http://modernizr.com/
* Version: 2.6.2
* License: MIT license
* Path: included in `webroot/js/modernizr.js`



### PHP Markdown
* Website: http://michelf.ca/projects/php-markdown/
* Version: 1.4.0, November 29, 2013
* License: PHP Markdown Lib Copyright © 2004-2013 Michel Fortin http://michelf.ca/
* Path: included in `3pp/php-markdown`




History
-----------------------------------


###History for Anax-MVC

v2.0.5* (2016-04-06)

* Enhance CResponse::redirect() to use framework urls, fix #22.


v2.0.5 (2016-01-15)

* Codestyle using phpcs.
* Enhancing verbosity on exception messages by printing out $di.
* Display valid routes and controllers to aid in 404 debugging.


v2.0.4 (2015-04-05)

* Navbar to display current item even if ? is present, fix 15.
* Updated composer.json and removed dependency to coverall.io.
* updated .travis.yml to remove dependency to coverall.io and do not install composer.phar.
* Adding example for shortcodes [BASEURL], [RELURL] and [ASSET].
* Adding example code on using forward and view creation, fix #13.
* `CDispatcherBasic->foward()` now returns a value, fix #12.
* Throw exception when headers already sent, fix #11.
* Removed testcase where exception was not thrown in creating session on hvm.



v2.0.3 (2015-01-12)

* Adding autoloader to composer.json to enable download from packagist using composer and require.
* Add PHP 5.6 as testenvironment in Travis.
* Testcases for \Anax\Session\CSession.
* Testcases for \Anax\DI\CDI.
* Improved exception when creation of service failes in $di.
* CNavbar now works for descendants of a menuitem.
* Correcting example `webroot/test/navigation-bar.php` to correctly show current menu item.
* Improved error messages in `CDispatcherbasic`.
* Improved errorhandling in trait `TInjectable`, now throwing more verbose exceptions on which class is using the trait.



v2.0.2 (2014-10-25)

* Added example for navigation bar and how to create urls in navbar.
* Add default route handler for route defined as '*'.
* Added empryt directory for app-specific file content `app/content`.
* Minor fixes to error messages.
* Several minor fixes to code formatting.
* Added `CUrl::createRelative()` for urls relative current frontcontroller.
* Reorganized and added testprograms in `webroot/test`.
* Improved documentation in `docs/documentation` and `webroot/docs.php`.
* Added config-file for phpunit `phpunit.xml.dist`.
* Added `phpdoc.dist.xml`.
* Enhanced `Anax\Navigation\CNavBar` with class in menu item.
* Added phpdocs to `docs/api`.


v2.0.1 (2014-10-17)

* Updates to match comments example.
* Introduced and corrected bug (issue #1) where exception was thrown instead of presenting a 404-page.
* Added `CSession::has()`.
* Corrected bug #2 in `CSession->name` which did not use the config-file for naming the session.
* Added `Anax\MVC\CDispatcherBasic` calling `initialize` om each controller.
* Added exception handling to provide views for 403, 404 and 500 http status codes and added example program in `webroot/error.php`.
* Added `docs` to init online documentation.
* Adding flash message (not storing in session).
* Adding testcases for CDispatcherBasic and now throwing exceptions from `dispatch()` as #3.
* Adding example for integrating CForm in Anax MVC and as a result some improvements to several places.
* Adding check to `Anax\MVC\CDispatcherBasic` to really check if the methods are part of the controller class and not using `__call()`.
* Improved error handling in `Anax\MVC\CDispatcherBasic` and testcase in `webroot/test_errormessages.php`.


v2.0.0 (2014-03-26)

* Cloned Anax-MVC and preparing to build Anax-MVC.
* Added autoloader for PSR-0.
* Not throwing exception in standard anax autoloader.
* Using anonomous functions in `bootstrap.php` to set up exception handler and autoloader.
* Added `$anax['style']` as inline style in `config.php` and `index.tpl.php`.
* Added unit testing with phpunit.
* Added automatic build with travis.
* Added codecoverage reports on coveralls.io.
* Added code quality through scrutinizer-ci.com.
* Major additions of classes to support a framework using dependency injections and service container.


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
