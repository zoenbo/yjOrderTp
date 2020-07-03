<?php

spl_autoload_register(function ($className) {
    if (strstr($className, 'alipay')) {
        require __DIR__ . '/../' . $className . '.php';
    }
});
