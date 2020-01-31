<?php
namespace think;
require __DIR__.'/run.inc.php';
$http = (new App())->http;
$response = $http->name('home')->run();
$response->send();
$http->end($response);