<?php

include __DIR__ . '/config.php';

spl_autoload_register(function ($className) {
    if (strstr($className, 'wxpay')) {
        require __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
    }
});
