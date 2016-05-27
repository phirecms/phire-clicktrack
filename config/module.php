<?php
/**
 * Module Name: phire-clicktrack
 * Author: Nick Sagona
 * Description: This is the click-track/stats module for Phire CMS 2
 * Version: 1.0
 */
return [
    'phire-clicktrack' => [
        'prefix'     => 'Phire\ClickTrack\\',
        'src'        => __DIR__ . '/../src',
        'routes'     => include 'routes.php',
        'resources'  => include 'resources.php',
        'nav.module' => [
            'name' => 'Click Stats',
            'href' => '/clicks',
            'acl'  => [
                'resource'   => 'clicks',
                'permission' => 'index'
            ]
        ],
        'events' => [
            [
                'name'     => 'app.dispatch.post',
                'action'   => 'Phire\ClickTrack\Event\Click::save',
                'priority' => 1000
            ]
        ]
    ]
];
