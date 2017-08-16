<?php
$routes = [
    "/nouvelle-personne" => "Person:new",
    "/new-skill" => "Skill:new",
    "/villes-par-code-postal/(\d{5})" => "Person:cityByPostalCode"
];

return $routes;