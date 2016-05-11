<?php

namespace Anax\MVC;

/**
 * Dispatching to controllers.
 *
 */
class CDispatcherBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    private $controllerName;    // Name of controller
    private $controller;        // Actual controller
    private $action;            // Name of action
    private $params;            // Params



    /**
     * Prepare the name.
     *
     * @param string $name to prepare.
     *
     * @return string as the prepared name.
     */
    public function prepareName($name)
    {
        $name = empty($name) ? 'index' : $name;
        $name = strtolower($name);
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        
        return $name;
    }



    /**
     * Set the name of the controller.
     *
     * @param string $name of the controller, defaults to 'index'.
     *
     * @return void
     */
    public function setControllerName($name = 'index')
    {
        $name = $this->prepareName($name) . 'Controller';

        $this->controllerName = $name;

        $this->controller = $this->di->has($name)
            ? $this->di->get($name)
            : null;
    }



    /**
     * Check if a controller exists with this name.
     *
     * @return bool
     */
    public function isValidController()
    {
        return is_object($this->controller);
    }



    /**
     * Set the name of the action.
     *
     * @param string $name of the action, defaults to 'index'.
     *
     * @return void
     */
    public function setActionName($name = 'index')
    {
        $this->action = lcfirst($this->prepareName($name)) . 'Action';
    }



    /**
     * Set the params.
     *
     * @param array $params all parameters, defaults to empty.
     *
     * @return void
     */
    public function setParams($params = [])
    {
        $this->params = $params;
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return bool
     */
    public function isCallable()
    {
        if (!method_exists($this->controller, $this->action)) {
            return false;
        }

        $reflection = new \ReflectionMethod($this->controller, $this->action);
        if (!$reflection->isPublic()) {
            return false;
        }

        return true;
    }


    /**
     * Inspect if callable and throw exception if parts is not callable.
     *
     * @return void
     * @throws \Exception
     */
    public function isCallableOrException()
    {
        $validController = $this->isValidController();

        $isMethod   = null;
        $isCallable = null;

        if ($validController) {
            $isMethod   = method_exists($this->controller, $this->action);
            $isCallable = $this->isCallable();
        }

        if (!($isMethod && $isCallable)) {
            $msg =
                "Trying to dispatch/forward to a non callable item. Controllername = '"
                . $this->controllerName
                . "', Action = '"
                . $this->action
                . "'."
            ;

            $not = $validController ? "" : "NOT";
            $msg .=
                " The controller named '$this->controllerName' does $not exist as part of of the
                service-container \$di.
                ";

            $services = $this->di->getServices();
            natcasesort($services);
            $services = implode("\n", $services);
            $msg .= " Loaded services are: <pre>$services</pre>\n";

            if ($validController) {
                $not = $isMethod ? "" : "NOT";
                $msg .= " The method '$this->action' does $not exist in the class '$this->controllerName'.";

                $not = $isCallable ? "" : "NOT";
                $msg .=
                    " The method '$this->action' is $not callable in the class '$this->controllerName'
                    (taking magic methods into consideration).";
            }

            throw new \Exception($msg);
        }
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function dispatch()
    {
        $handler = [$this->controller, 'initialize'];
        if (method_exists($this->controller, 'initialize') && is_callable($handler)) {
            call_user_func($handler);
        }

        $this->isCallableOrException();

        return call_user_func_array([$this->controller, $this->action], $this->params);
    }


    /**
     * Forward to a controller, action with parameters.
     *
     * @param array $forward with details for controller, action, parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function forward($forward = [])
    {
        $controller = isset($forward['controller'])
            ? $forward['controller']
            : null;

        $action = isset($forward['action'])
            ? $forward['action']
            : null;
        
        $params = isset($forward['params'])
            ? $forward['params']
            : [];

        $this->setControllerName($controller);
        $this->setActionName($action);
        $this->setParams($params);

        $this->isCallableOrException();
        return $this->dispatch();
    }
}
