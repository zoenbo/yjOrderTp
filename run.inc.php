<?php
namespace think;

session_cache_limiter('private_no_cache');
header('Cache-Control:private');

if (strstr($_SERVER['PHP_SELF'],'run.inc.php')) exit;
if (version_compare(PHP_VERSION,'7.1.0','<')) exit('require PHP > 7.1.0!');

define('ROOT_PATH',__DIR__);
require __DIR__.'/vendor/autoload.php';