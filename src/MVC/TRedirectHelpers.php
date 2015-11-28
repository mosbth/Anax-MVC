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
    
        /**
     * Redirect to another page.
     *
     * @param string $url to redirect to
     *
     * @return void
     */
    public function redirect($url, $message = NULL, $message_type = NULL){
 
        if($message !=NULL){
            $_SESSION['message'] = $message;
        }
        if($message_type !=NULL){
            $_SESSION['message_type'] = $message_type;
        }
        
        header('Location: ' . $url);
        exit();
    }//END OF REDIRECT
    
    /* ==== GET LAST URL ==== */
    public function getLastUrl($default = null)
    {
    	$url = !empty($this->server['HTTP_REFERER']) ? $this->server['HTTP_REFERER'] : $default;
    	 
    	return $url;
    }

}
