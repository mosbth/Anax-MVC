<?php

namespace Anax\Flash;

class CFlash
{
    private $icons = [
        'notice' => 'fa-info',
        'warning' => 'fa-warning',
        'success' => 'fa-check',
        'error' => 'fa-times-circle',
    ];
    /**
     * Constructor, sets the session.
     */
    public function __construct()
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
    }

    /**
     * Clear the session
     * @param  boolean $startAgain Do you want to start the session again?
     * @return void
     */
    public function clear($startAgain = true)
    {
        unset($_SESSION['flash']);
        if ($startAgain) {
            if (!isset($_SESSION['flash'])) {
                $_SESSION['flash'] = [];
            }
        }
    }
    /**
     * Set the session key
     * @param String $key   the key
     * @param String $value the value
     */
    private function setKey($key, $value)
    {
        $_SESSION['flash'][] = [
            'type' => $key,
            'message' => $value,
        ];
    }

    /**
     * Error flash message
     * @param  String $message The message
     * @return void
     */
    public function error($message)
    {
        $this->setKey('error', $message);
    }

    /**
     * Notice flash message
     * @param  String $message The message
     * @return void
     */
    public function notice($message)
    {
        $this->setKey('notice', $message);
    }

    /**
     * Warning flash message
     * @param  String $message The message
     * @return void
     */
    public function warning($message)
    {
        $this->setKey('warning', $message);
    }

    /**
     * Success flash message
     * @param  String $message The message
     * @return void
     */
    public function success($message)
    {
        $this->setKey('success', $message);
    }

    /**
     * Get the html
     * @return String
     */
    public function get($icons = true)
    {

        $messages = "";
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $key => $value) {
                $messages .= "<div class={$value['type']}Message>";
                $ico = $value['type'];
                if ($icons) {
                    $messages .= "<i class='fa {$this->icons[$ico]}'></i>";
                }
                $messages .= " {$value['message']}</div>";
            }
            $this->clear();
        }
        return $messages;
    }
}
