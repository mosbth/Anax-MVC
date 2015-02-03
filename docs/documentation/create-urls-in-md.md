Creating urls and linking to resources from text and Markdown files.
====================================

First you should read how you in general [use the framework to create urls to routes and resources]([BASEURL]create-urls).

Now, how is this done in textfiles or Markdown?

To solve this it exists some shortcodes that maps to the frameworks methods for creating links.

| Shortcode     | Method in `$di->url`     | Result |
|---------------|--------------------------|--------|
| `BASEURL` | `create($uri)`           | Creates an url by prepending the siteurl and the baseurl to `$uri`. The scriptname is also prepended if the url type is `URL_APPEND`. The scriptname is not prepended when the url-type is `URL_CLEAN`. |
| `RELURL`  | `createRelative($uri)`   | Same as above but never prepending scriptname. |
| `ASSET`   | `asset($url)`            | Creates an url by prepending the siteurl and the baseurl to $url. The scriptname is also prepended if the url type is URL_APPEND. The scriptname is not prepended when the url-type is ORL_CLEAN. |

Now, lets see some examples.



Use textfiles and Markdown as content
------------------------------------

You can write content as textfiles or Markdown-files and you then integrate them into views like this.

```
$byline = $app->fileContent->get('byline.md');
$byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
```

The code above shows how you open the textfile as a ordinary file and then parse it through a list of filters. The result in `$byline` is usually HTML.

The examples below are written in Markdown. But the usage of these shortcodes is tied to the usage of the filter `shortcode` which is implemented in the class [`Anax\Content\CTextFilter`](https://github.com/mosbth/Anax-MVC/blob/master/src/Content/CTextFilter.php).



Creating links to routes with \[BASEURL\]
------------------------------------

To add the baseurl (of current frontcontroller) to a link, use the shortcode \[BASEURL\] like this in your Markdown document.

```
Here is a [link to this page]([BASEURL]create-urls-in-md).

The content of BASEURL is [ BASEURL ].
```

The resulting HTML turns out like this.

> Here is a [link to this page]([BASEURL]create-urls-in-md).

> The content of BASEURL is [BASEURL].

Or like this in its source.

```
<p>Here is a <a href="http://localhost/git/Anax-MVC/webroot/doc.php/create-urls-in-md">link to this page</a>.</p>

<p>The content of BASEURL is http://localhost/git/Anax-MVC/webroot/doc.php/.</p>
```



Creating links to resources with \[RELURL\]
------------------------------------

To add the webapps baseurl (but always without the scriptname) to a resource on the website, use the shortcode `\[RELURL\]` like this in your Markdown document.

```
Here is a [link to the humans.txt]([RELURL]humans.txt).

The content of RELURL is [ RELURL ].
```

The resulting HTML turns out like this.

> Here is a [link to the humans.txt]([RELURL]humans.txt).

> The content of RELURL is [RELURL].

Or like this, in its source.

```
<p>Here is a <a href="http://localhost/git/Anax-MVC/webroot/humans.txt">link to the humans.txt</a>.</p>

<p>The content of RELURL is http://localhost/git/Anax-MVC/webroot/.</p>
```



Linking to images with \[ASSET\]
------------------------------------

To add an image to the website and create the link relative the current webapp. Use the shortcode `\[ASSET\]` like this in your Markdown document.

```
Here is an image.

![Alt text]([ ASSET ]favicon.ico)

The content of ASSET is [ ASSET ].
```

The resulting HTML turns out like this.

> Here is an image.

> ![Alt text]([ASSET]favicon.ico)

> The content of ASSET is [ASSET].

Or like this, in its source.

```
<p>Here is an image.</p>

<p><img src="http://localhost/git/Anax-MVC/webroot//favicon.ico" alt="Alt text" /></p>
```
