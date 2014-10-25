Creating urls and linking to resources
====================================

This is how you can link to various resources.

`$di->url` is the resource that helps you create links in general. Let this service manage creation of all your links. This makes it easier to move around your webroot and frontcontrollers withih a website.

[Here is a testprogram using the examples below]([RELURL]test/create-urls.php).



Creating links
------------------------------------

For creating urls to other pages.

| Method in `$di->url`     | Result |
|--------------------------|--------|
| `create($uri)`           | Creates an url by prepending the siteurl and the baseurl to `$uri`. The scriptname is also prepended if the url type is `URL_APPEND`. The scriptname is not prepended when the url-type is `URL_CLEAN`. |
| `createRelative($uri)`   | Same as above but never prepending scriptname. |



###Example on creating links

```
//
// Create urls to routes within current frontcontroller
// Prepended with siteurl and baseurl.
// Scriptname is prepended if URL_APPEND.
// Scriptname is not prepended if URL_CLEAN.
//
$this->url->create();           // Home route
$this->url->create("about");    // Link to a route named "about"
$this->url->create("about/me"); // Link to a route named "about/me"

//
// Create absolute url with current site
// Prepended with siteurl only
//
$this->url->create("/sitemap.xml");
$this->url->create("/robots.txt");

//
// Create urls relative the base directory of current frontcontroller.
// Prepended with siteurl and baseurl.
// Scriptname is never prepended.
//
$this->url->createRelative("doc.php");
$this->url->createRelative("../doc.php");
$this->url->createRelative("test");
$this->url->createRelative("test/testcase1.php");
```



Linking to assets
------------------------------------

Its common to separate linking to assets from linking to other urls. The benefit of this is to be able to create webroots in subdirectories and still link to assets in another place, or use a completely different server for static assets which enhances performance.

For linking to other static assets such as `img`, `js`, `css`.

| Method in `$di->url`     | Result |
|--------------------------|--------|
| `asset($url)`           | Creates an url by prepending the siteurl and the baseurl to $url. The scriptname is also prepended if the url type is URL_APPEND. The scriptname is not prepended when the url-type is ORL_CLEAN. |



###Example on linking to assets

```
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>
```



Default setup
------------------------------------

The url-service is created in the during startup. See the DI\CDIFactoryDefault for its default settings. It might look like this.

```
$di->setShared('url', function () {
    $url = new \Anax\Url\CUrl();
    $url->setSiteUrl($this->request->getSiteUrl());
    $url->setBaseUrl($this->request->getBaseUrl());
    $url->setStaticSiteUrl($this->request->getSiteUrl());
    $url->setStaticBaseUrl($this->request->getBaseUrl());
    $url->setScriptName($this->request->getScriptName());
    $url->setUrlType($url::URL_APPEND);
    return $url;
});
```
