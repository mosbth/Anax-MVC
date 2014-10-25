Throw exceptions to generate error pages
====================================

Sometimes you need to generate a error page with a HTTP status code- usually 403, 404 or 500 - from a route handler.

This can easily be done by throwing an exception, as example shows below.

```
throw new \Anax\Exception\NotFoundException("Here is the details, if any.");
```

Above exception will generate a 404-page using an internal route. An internal route is available in the router, but only for internal use and it can not be accessed by a direct url.


The `$app->handle()` is executed within a try/catch-block, all exceptions are caught and analysed. If the exception-code matches a known HTTP status code, a matching internal route is used to handle it.

The exceptions can be thrown anywhere within a route-handler.



Classes involved
------------------------------------

The following classes are relevant.

| Class/Method                  | Details                                             | 
|-------------------------------|-----------------------------------------------------|
| \Anax\DI\CDIFactoryDefault    | Creates the internal routes as part of the router. |
| \Anax\Exception\              | Examples on Exceptions throwing a statuscode.       | 
| \Anax\Route\CRouter->handle() | Catching the exception and forwards to the internal route. |



Test case
------------------------------------

[Here is a testcase]([RELURL]test/exception-as-http-error-page.php).

