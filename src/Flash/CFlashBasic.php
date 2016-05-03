<?php

namespace Anax\Flash;

/**
 * Store messages for flashing them to the user as user feedback.
 *
 */
class CFlashBasic
{
    /**
     * Properties
     *
     */
    protected $message;



   /**
     * Set a message.
     *
     * @param string $message a message.
     *
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }



   /**
     * Get the message.
     *
     * @return string
     *
     */
    public function getMessage()
    {
        return $this->message;
    }
}
