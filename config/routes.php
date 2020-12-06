<?php
//'request_method|uri_pattern' => 'controller/method_to_call/...params'

return [
    'GET|api/articles/([0-9]+)' => 'ArticleController/show/$1',
    'GET|api/articles' => 'ArticleController/index',
    'PUT|api/articles/([0-9]+)' => 'ArticleController/update/$1',
    'POST|api/articles' => 'ArticleController/store',
    'DELETE|api/articles/([0-9]+)' => 'ArticleController/destroy/$1',

    'POST|api/users' => 'UserController/store',
    'PUT|api/users/([0-9]+)' => 'UserController/update/$1',

    'POST|api/auth/login' => 'AuthController/login',
    'POST|api/auth/logout' => 'AuthController/logout',
];