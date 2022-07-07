<?php

$container->loadFromExtension('framework', [
    'secret' => 'F00',
    'session' => [
        'handler_id' => null,
        'cookie_secure' => 'auto',
        'cookie_samesite' => 'lax',
        'storage_factory_id' => 'session.storage.factory.native',
    ],
    'php_errors' => [
        'log' => true,
    ],
    'test' => true,
    'router' => [
        'utf8' => true,
    ],
]);
