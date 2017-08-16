<?php

use m2i\Framework\Router;
use \m2i\Framework\Dispatcher;
use \m2i\Framework\ServiceContainer as SC;

//Définition des constantes
define("ROOT_PATH", dirname(__DIR__));
define("WEB_PATH", __DIR__);
define("SRC_PATH", ROOT_PATH."/src");
define("VIEW_PATH", SRC_PATH."/views");
define("CTRL_PATH", SRC_PATH."/controllers");
define("MODEL_PATH", SRC_PATH."/models");

//Chargement des constantes de l'application
require SRC_PATH."/conf/const.php";
//chargement du framework mvc
require ROOT_PATH. "../vendor/autoload.php";

//Définition des dépendances de l'application
SC::add("db.connection", function(){
    return new \PDO(
        "mysql:host=localhost;dbname=training_center;charset=utf8",
        "root", "", [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION]);
});

SC::add("person.dao", function (){
   return new \m2i\project\Model\DAO\PersonDAO(SC::get("db.connection"));
});

SC::add("city.dao", function (){
    return new \m2i\project\Model\DAO\CitieDAO(SC::get("db.connection"));
});

SC::add("person.dto", function (){
    return new \m2i\project\Model\Entity\PersonDTO();
});

SC::add("view", function (){
    return new \m2i\Framework\View();
});

//récupération de la liste des routes
$routes = require SRC_PATH."/conf/routes.php";

$url = filter_input(INPUT_GET, "c", FILTER_SANITIZE_URL);

$router = new Router($url, $routes);
$dispatcher = new Dispatcher($router, "\\m2i\\project\\Controller\\");
$dispatcher->dispatch();
