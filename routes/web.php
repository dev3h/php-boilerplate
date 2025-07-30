<?php

$router->get('/', 'HomeController@index');
$router->get('/product', 'ProductController@index');
$router->get('/product/create', 'ProductController@create')->name('product.create');