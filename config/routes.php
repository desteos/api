<?php
//'request_method|uri_pattern' => 'controller/method_to_call/...params'

return [
    'GET|articles/([0-9]+)' => 'ArticleController/show/$1',

    'GET|articles' => 'ArticleController/index',

    'PUT|articles/([0-9]+)' => 'ArticleController/update/$1',

    'POST|articles' => 'ArticleController/store',

    'DELETE|articles/([0-9]+)' => 'ArticleController/destroy/$1',

    'DELETE|articles' => 'ArticleController/destroy',
];