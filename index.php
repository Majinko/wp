<?php
session_start();
mb_internal_encoding("UTF-8");

include 'helpers.php';
include 'utils/Constants.php';
include 'utils/CurlUtils.php';

// Callback for load class
function autoload(string $class)
{
    if (preg_match('/Controller$/', $class))
        require("controller/" . $class . ".php");
}

// Register callback 
spl_autoload_register("autoload");

// Create router and process parameter from user from url
$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));

$router->renderTemplate();