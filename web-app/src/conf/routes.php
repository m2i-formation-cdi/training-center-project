<?php
$routes = [
    "/nouvelle-personne" => "Person:new",
    "/villes-par-code-postal/(\d{5})" => "Person:cityByPostalCode",
    "/formations/presence" => "Formation:sessionsEnrollment",
    "/formations/presence/(\d+)" => "Formation:printSessionEnrollment",
];

return $routes;