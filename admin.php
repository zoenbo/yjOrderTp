<?php

namespace think;

ob_start(function_exists('ob_gzhandler') ? 'ob_gzhandler' : null);

function _runtime()
{
    $temp = explode(' ', microtime());
    return $temp[0] + $temp[1];
}
define('START_TIME', _runtime());

require __DIR__ . '/run.inc.php';
$http = (new App())->http;
$response = $http->name('admin')->run();
$response->send();
$http->end($response);
