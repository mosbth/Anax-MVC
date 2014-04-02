<?php

namespace Anax\Response;

/**
 * Handling a response.
 *
 */
class CResponseBasic
{


    /**
    * Properties
    *
    */
    private $headers; // Set all headers to send



    /**
     * Set headers.
     *
     * @param string $header type of header to set
     *
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header[] = $header;
    }



    /**
     * Send headers.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        if (empty($this->headers)) {
            return;
        }

        foreach ($this->headers as $header) {
            switch ($this->header) {
                case '403':
                    header('HTTP/1.0 403 Forbidden');
                    break;

                case '404':
                    header('HTTP/1.0 404 Not Found');
                    break;

                default:
                    throw new \Exception("Unkown header type.");
            }
        }

        return $this;
    }



    /**
     * Redirect to another page.
     *
     * @param string $url to redirect to
     *
     * @return $this
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}
