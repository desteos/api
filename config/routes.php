<?php
//'request_method|uri_pattern' => 'controller/method_to_call/...params'

return [
    /* Articles */
    'GET|api/v1/articles/([0-9]+)' => [
        'action' => 'ArticleController/show/$1'
    ],
    'GET|api/v1/articles' => [
        'action' => 'ArticleController/index'
    ],
    'PUT|api/v1/articles/([0-9]+)' => [
        'action' => 'ArticleController/update/$1',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/v1/articles' => [
        'action' => 'ArticleController/store',
        'middlewares' => ['Authenticated']
    ],
    'DELETE|api/v1/articles/([0-9]+)' => [
        'action' => 'ArticleController/destroy/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Users */
    'POST|api/v1/users' => [
        'action' => 'UserController/store',
        'middlewares' => ['Authenticated']
    ],
    'PUT|api/users/([0-9]+)' => [
        'action' => 'UserController/update/$1',
        'middlewares' => ['Authenticated']
    ],

    /* Auth */
    'POST|api/v1/auth/login' => [
        'action' => 'AuthController/login'
    ],
    'POST|api/v1/auth/logout' => [
        'action' => 'AuthController/logout',
        'middlewares' => ['Authenticated']
    ],
    'POST|api/v1/auth/refresh-tokens' => [
        'action' => 'AuthController/refreshTokens'
    ],
];