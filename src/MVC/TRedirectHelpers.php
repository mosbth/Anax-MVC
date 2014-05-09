<?php

namespace Anax\MVC;

/**
 * Helpers for redirecting to other pages and controllers.
 *
 */
trait TRedirectHelpers
{

    /**
     * Redirect to current or another route.
     *
     * @param string $route the route to redirect to, 
     * null to redirect to current route, "" to redirect to baseurl.
     *
     * @return void
     */
    public function redirectTo($route = null)
    {
        if (is_null($route)) {
            $url = $this->di->request->getCurrentUrl();
        } else {
            $url = $this->di->url->create($route);
        }
        $this->di->response->redirect($url);
    }
}
