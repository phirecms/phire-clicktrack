<?php
/**
 * phire-clicktrack routes
 */
return [
    '/download/:id' => [
        'controller' => 'Phire\ClickTrack\Controller\IndexController',
        'action'     => 'download'
    ],
    APP_URI => [
        '/clicks[/]' => [
            'controller' => 'Phire\ClickTrack\Controller\ClicksController',
            'action'     => 'index',
            'acl'        => [
                'resource'   => 'clicks',
                'permission' => 'index'
            ]
        ]
    ]
];
