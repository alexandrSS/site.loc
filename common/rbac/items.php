<?php
return [
    'BackendController' => [
        'type' => 2,
        'description' => 'Master controller backend application',
    ],
    'indexAdmin' => [
        'type' => 2,
        'description' => 'Admin index',
    ],
    'indexUser' => [
        'type' => 2,
        'description' => 'List Users and Errors',
    ],
    'viewUser' => [
        'type' => 2,
        'description' => 'Users viewing',
    ],
    'createUser' => [
        'type' => 2,
        'description' => 'Create a user',
    ],
    'updateUser' => [
        'type' => 2,
        'description' => 'Update user',
    ],
    'deleteUser' => [
        'type' => 2,
        'description' => 'Delete user',
    ],
    'indexCategory' => [
        'type' => 2,
        'description' => 'List Category and Errors',
    ],
    'viewCategory' => [
        'type' => 2,
        'description' => 'Category viewing',
    ],
    'createCategory' => [
        'type' => 2,
        'description' => 'Create a Category',
    ],
    'updateCategory' => [
        'type' => 2,
        'description' => 'Update Category',
    ],
    'deleteCategory' => [
        'type' => 2,
        'description' => 'Delete Category',
    ],
    'indexPage' => [
        'type' => 2,
        'description' => 'List Page and Errors',
    ],
    'viewPage' => [
        'type' => 2,
        'description' => 'Pages viewing',
    ],
    'createPage' => [
        'type' => 2,
        'description' => 'Create a Page',
    ],
    'updatePage' => [
        'type' => 2,
        'description' => 'Update Page',
    ],
    'deletePage' => [
        'type' => 2,
        'description' => 'Delete Page',
    ],
    0 => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'group',
    ],
    3 => [
        'type' => 1,
        'description' => 'Moderator',
        'ruleName' => 'group',
        'children' => [
            0,
            'BackendController',
            'indexAdmin',
            'indexUser',
            'viewUser',
            'createUser',
            'updateUser',
            'indexCategory',
            'viewCategory',
            'createCategory',
            'updateCategory',
            'indexPage',
            'viewPage',
            'createPage',
            'updatePage',
        ],
    ],
    1 => [
        'type' => 1,
        'description' => 'Administrator',
        'ruleName' => 'group',
        'children' => [
            3,
            'deleteUser',
            'deleteCategory',
            'deletePage',
        ],
    ],
    2 => [
        'type' => 1,
        'description' => 'Super Administrator',
        'ruleName' => 'group',
        'children' => [
            1,
        ],
    ],
];
