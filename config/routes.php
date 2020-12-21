<?php
//'request_method|uri_pattern' => 'middleware1,middleware2|controller/method_to_call/...params'
// controller name must start with | symbol

return [
    'GET|api/articles/([0-9]+)' => '|ArticleController/show/$1',
    'GET|api/articles' => '|ArticleController/index',
    'PUT|api/articles/([0-9]+)' => 'Authenticated|ArticleController/update/$1',
    'POST|api/articles' => 'Authenticated|ArticleController/store',
    'DELETE|api/articles/([0-9]+)' => 'Authenticated|ArticleController/destroy/$1',

    'POST|api/users' => '|UserController/store',
    'PUT|api/users/([0-9]+)' => 'Authenticated|UserController/update/$1',

    'POST|api/auth/login' => '|AuthController/login',
    'POST|api/auth/logout' => 'Authenticated|AuthController/logout',
    'POST|api/auth/refresh-tokens' => 'Authenticated|AuthController/refreshTokens',
];