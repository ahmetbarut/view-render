<?php
require_once  "vendor/autoload.php";

$view = new \ahmetbarut\View\Engine([
    "view" => __DIR__ . "/view",
    'cache' => __DIR__ . '/cache'
]);
$view->load('home2', [
    "echo" => "burası echo",
    "lorem" => "asdsad",
    "todos" => [
        "Todo 1",
        "Todo 2",
        "Todo 3",
        "Todo 4",
        "Todo 5",
    ]

]);
