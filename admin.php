<?php
namespace think;
ob_start(function_exists('ob_gzhandler') ? 'ob_gzhandler' : NULL);
function _runtime(){
	$mitime = explode(' ',microtime());
	return $mitime[0] + $mitime[1];
}
define('START_TIME',_runtime());

require __DIR__.'/run.inc.php';
$http = (new App())->http;
$response = $http->name('admin')->run();
$response->send();
$http->end($response);