<?php
namespace m2i\Framework;


class Router implements IRouter
{

    /**
     * @var string
     */
    private $controllerName = "DefaultController";

    /**
     * @var string
     */
    private $actionName = "indexAction";

    /**
     * @var array
     */
    private $actionParameters = [];

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     * @param string $url
     * @param array $routes
     */
    public function __construct($url, array $routes)
    {
        //Ajout du caractère / initial s'il n'existe pas
        if(substr($url, 0,1) != "/"){
            $url = "/". $url;
        }

        $this->url = $url;
        $this->routes = $routes;

        $this->matchRoutes();
    }


    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array
     */
    public function getActionParameters(): array
    {
        return $this->actionParameters;
    }

    /**
     * Résolution des routes pour obtenir un nom de contrôleur,
     * un nom d'action et un tableau de paramètres
     */
    private function matchRoutes()
    {
        foreach ($this->routes as $path => $target) {
            $route = "#^{$path}$#";

            if (preg_match($route, $this->url, $matches)) {
                //Récupération de l'action et du contrôleur
                $parts = explode(":", $target);
                //élimination du premier élément du tableau des correspondances
                array_shift($matches);

                $this->controllerName = $parts[0]."Controller";
                $this->actionName = $parts[1]."Action";
                $this->actionParameters = $matches;

                break;
            }
        }

    }


}