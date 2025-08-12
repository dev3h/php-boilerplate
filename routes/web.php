<?php

$router->get('/', 'HomeController@index');
$router->get('/product', 'ProductController@index');
$router->get('/product/create', 'ProductController@create')->name('product.create');
$router->post('/product/create', 'ProductController@store')->name('product.store');
$router->get('/product/edit/:id', 'ProductController@edit')->name('product.edit');
$router->post('/product/update', 'ProductController@update')->name('product.update');