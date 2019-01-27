<?php


return [
    'database' => [
        'default_connection' => 'live',
        'connections' => array(
            'live' => array(
                'server' => 'localhost',
                'database' => 'task',
                'username' => 'task',
                'password' => 'password',
                'charset' => 'utf8',
            ),
        ),
    ],
    'connectors' => [
        'outlook' => [
            'oauth' => [
                'app_id' => 'eeeeeeee-bbbb-bbbb-bbbb-dddddddddddd',
                'app_password' => 'password',
                'redirect_uri' => 'https://example.com/tasks/authorize.php',
                'signin_uri' => 'https://example.com/tasks/signin.php'
            ]
        ]
    ]
];



