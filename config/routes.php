<?php

return [
    'GET|articles' => 'ArticleController@index',
    'GET|articles/1' => 'ArticleController@show',
    'POST|articles' => 'ArticleController@store',
    'DELETE|articles/1' => 'ArticleController@destroy',
];