<?php
//'request_method|uri_pattern' => 'path\to\controller/method_to_call/...params'

return [
    /* Articles */
    'GET|api/v1/articles/([0-9]+)' => [
        'action' => 'v1\ArticleController/show/$1'
    ],
    'GET|api/v1/articles' => [
        'action' => 'v1\ArticleController/index'
    ],
    'PUT|api/v1/articles/([0-9]+)' => [
        'action' => 'v1\ArticleController/update/$1',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/v1/articles' => [
        'action' => 'v1\ArticleController/store',
        'middlewares' => ['Authenticated']
    ],
    'DELETE|api/v1/articles/([0-9]+)' => [
        'action' => 'v1\ArticleController/destroy/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Users */
    'POST|api/v1/users' => [
        'action' => 'v1\UserController/store',
        'middlewares' => ['Authenticated']
    ],
    'PUT|api/users/([0-9]+)' => [
        'action' => 'v1\UserController/update/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Auth */
    'POST|api/v1/auth/login' => [
        'action' => 'v1\AuthController/login'
    ],
    'POST|api/v1/auth/logout' => [
        'action' => 'v1\AuthController/logout',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/v1/auth/refresh-tokens' => [
        'action' => 'v1\AuthController/refreshTokens'
    ],
];