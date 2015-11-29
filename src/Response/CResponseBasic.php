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
        $this->headers[] = $header;
    }



    /**
     * Check if headers are already sent and throw exception if it is.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function checkIfHeadersAlreadySent()
    {
        if (headers_sent($file, $line)) {
            throw new \Exception("Trying to send headers but headers already sent, output started at $file line $line.");
        }
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

        $this->checkIfHeadersAlreadySent();

        foreach ($this->headers as $header) {
            switch ($header) {
                case '403':
                    header('HTTP/1.0 403 Forbidden');
                    break;

                case '404':
                    header('HTTP/1.0 404 Not Found');
                    break;

                case '500':
                    header('HTTP/1.0 500 Internal Server Error');
                    break;

                default:
                    throw new \Exception("Trying to sen unkown header type: '$header'.");
            }
        }

        return $this;
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

/* ==== DISPLAY ERROR OR SUCCESS MESSAGE ==== */
    function displayMessage(){
        if(!empty($_SESSION['message'])){
            $message = $_SESSION['message'];
            
            if(!empty($_SESSION['message_type'])){
                $message_type = $_SESSION['message_type'];
                
                if($message_type == 'error'){
                    echo '<div id="errormessage" class="alert alert-danger">' . $message . '</div>';
                }else{
                    echo '<div id="successmessage" class="alert alert-success">' . $message . '</div>';
                }
            }//END OF MESSAGE TYPE
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }else{
            echo '';
        }     
                                
    }//END OF DISPLAY MESSAGE
           
}
