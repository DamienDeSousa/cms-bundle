<?php

$container->loadFromExtension('cmf_routing', [
    'chain' => [
        'routers_by_id' => [
            'router.default' => 200,
            'cmf_routing.dynamic_router' => 100,
        ],
    ],
    'dynamic' => [
        'route_provider_service_id' => 'cms_dades.page_route_loader',
    ],
]);
