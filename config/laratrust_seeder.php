<?php

return [
    'role_structure' => [
        'SuperAdmin' => [
            'users' => 'c,r,u,d',
            // 'acl' => 'c,r,u,d',
            'roles' => 'c,r,u,d'
        ],
        'Admin' => [
            'users' => 'c,r,u,d',
            'roles' => 'r'
        ],
        'Editor' => [
            'users' => 'c,r',
            'roles' => 'r'
        ],

    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'inport',
        'e' => 'export',
    ]
];
