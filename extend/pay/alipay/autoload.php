<?php
function alipayLoad($className){
	if (strstr($className,'alipay')) require __DIR__.'/../'.$className.'.php';
}
spl_autoload_register('alipayLoad');