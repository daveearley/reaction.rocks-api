<?php

/** @var Router $router */

use Illuminate\Routing\Router;

$router = app()->get('router');

$router->any('/health', function () {
    return 'ok';
});
