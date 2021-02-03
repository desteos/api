<?php
//'request_method|uri_pattern' => 'controller/method_to_call/...params'

return [
    /* Articles */
    'GET|api/articles/([0-9]+)' => [
        'action' => 'ArticleController/show/$1'
    ],
    'GET|api/articles' => [
        'action' => 'ArticleController/index'
    ],
    'PUT|api/articles/([0-9]+)' => [
        'action' => 'ArticleController/update/$1',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/articles' => [
        'action' => 'ArticleController/store',
        'middlewares' => ['Authenticated']
    ],
    'DELETE|api/articles/([0-9]+)' => [
        'action' => 'ArticleController/destroy/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Users */
    'POST|api/users' => [
        'action' => 'UserController/store',
        'middlewares' => ['Authenticated']
    ],
    'PUT|api/users/([0-9]+)' => [
        'action' => 'UserController/update/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Auth */
    'POST|api/auth/login' => [
        'action' => 'AuthController/login'
    ],
    'POST|api/auth/logout' => [
        'action' => 'AuthController/logout',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/auth/refresh-tokens' => [
        'action' => 'AuthController/refreshTokens'
    ],
];