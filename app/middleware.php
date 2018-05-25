<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add($container->get('csrf'));

$app->add(new App\Middlewares\TrailingSlash());



