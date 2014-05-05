Throw exceptions to generate error pages
====================================

Sometimes you need to generate a error page - usually 403, 404 or 500 - from a route handler. 

This can easily be done by throwing an exception, as example shows below.

It works like this.

1. The `$app->handle()` is executed within a try/catch-block, all exceptions are caught and analysed.
2. If the exception-code matches a known HTTP status code, an internal route is used to handle it.
3. There are internal routes for 403, 404 and 500 status codes.
4. The internal routes are defined together with the `$app->router` (see factory for `$di`).
5. The internal routes uses a error controller `Anax/MVC/ErrorController`.
6. The `ErrorController` uses views `default/error`.

The exceptions can be thrown anywhere within the codeblock of `$route->handle()`.

Here is some examples on how to do it.



403 Forbidden
------------------------------------

You can throw an exception, `Anax\Exception\ForbiddenException`, to generate a 403 page.

```
// Throw ForbiddenException to get a 403 page
$app->router->add('403', function () use ($app) {

    throw new \Anax\Exception\ForbiddenException("Here is the details, if any.");

});
```

Try it out and [get a 403-page](error.php/403).



404 Not Found
------------------------------------

You can throw an exception, `Anax\Exception\NotFoundException`, to generate a 404 page.

```
// Throw NotFoundException to get a 404 page
$app->router->add('404', function () use ($app) {

    throw new \Anax\Exception\NotFoundException("Here is the details, if any.");

});
```

Try it out and [get a 404-page](error.php/404).



500 Internal Server Error
------------------------------------

You can throw an exception, `Anax\Exception\InternalServerErrorException`, to generate a 500 page.

```
// Throw InternalServerErrorException to get a 500 page
$app->router->add('500', function () use ($app) {

    throw new \Anax\Exception\InternalServerErrorException("Here is the details, if any.");

});
```

Try it out and [get a 500-page](error.php/500).

