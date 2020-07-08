<?php

return [
    'default' => 'file',
    'stores' => [
        'file' => [
            'type' => 'File',
            'path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR
        ]
    ]
];
