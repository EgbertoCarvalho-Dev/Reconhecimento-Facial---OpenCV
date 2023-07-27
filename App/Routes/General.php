<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Recognize;
use Slim\Routing\RouteCollectorProxy;


$app->group('/api/v1', function (RouteCollectorProxy $group) {
    $group->post('/register', Recognize::class . ':register');
    $group->post('/compare-faces', Recognize::class . ":compareFaces");













    if (GENERATE_TOKEN == true) {
        $group->group('/token', function (RouteCollectorProxy $group2) {
            $group2->post('/register', Recognize::class . ':registerToken');
        });
    }
});
