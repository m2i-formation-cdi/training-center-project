<?php
$routes = [
    "/nouvelle-personne" => "Person:new",
    "/villes-par-code-postal/(\d{5})" => "Person:cityByPostalCode",
    "/catalogue-toutes-formations" => "TrainingProgram:displayPage",
    "/catalogue-formations" => "TrainingProgram:displayProgramList"
];

return $routes;