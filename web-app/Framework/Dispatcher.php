<?php

namespace m2i\Framework;


class Dispatcher
{
    /**
     * @var IRouter
     */
    private $router;

    private $namespace;

    /**
     * Dispatcher constructor.
     * @param IRouter $router
     */
    public function __construct(IRouter $router, $namespace)
    {
        $this->router = $router;
        $this->namespace = $namespace;
    }

    /**
     * Exécute une action sur un contrôleur en passant des paramètres
     */
    public function dispatch(){
        //Instanciation du contrôleur
        $controllerClassname = $this->namespace.$this->router->getControllerName();
        $controller = new $controllerClassname();

        //Exécution de l'action
        call_user_func_array(
            [$controller, $this->router->getActionName()],
            $this->router->getActionParameters());
    }


}