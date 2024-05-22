<?php

//echo $_SERVER["REQUEST_URI"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[2];

//$id = isset($parts[3]) ? $parts[3] : null;
$id = $parts[3] ?? null;

//echo $resource, ", " , $id;

//echo $_SERVER["REQUEST_METHOD"], "\n";

if ($resource != "tasks"){
    
    //header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
    http_response_code(404);
    exit;
}