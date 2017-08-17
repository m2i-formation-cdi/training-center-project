<?php
$routes = [
    "/nouvelle-personne" => "Person:new",
    "/villes-par-code-postal/(\d{5})" => "Person:cityByPostalCode",
    "/formations" => "Training:index",
    "/formations/presence" => "Training:sessionsEnrollment",
    "/formations/presence/(\d+)" => "Training:printSessionEnrollment",
    "/new-skill" => "Skill:new",
    "/villes-par-code-postal/(\d{5})" => "Person:cityByPostalCode"
];

return $routes;