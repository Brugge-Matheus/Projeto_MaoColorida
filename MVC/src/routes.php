<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/contato', 'ContatoController@contato');