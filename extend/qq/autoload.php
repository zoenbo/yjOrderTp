<?php
function qqLoad($className){
	if (strstr($className,'QqLogin')) require __DIR__.'/'.str_replace('QqLogin\\','',$className).'.class.php';
}
spl_autoload_register('qqLoad');