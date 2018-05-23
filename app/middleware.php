<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// $app->add($container->get('csrf'));

$app->add(new App\Middlewares\TrailingSlash());

// $app->add(new \League\OAuth2\Server\Middleware\ResourceServerMiddleware($container->get('oauth2_security')->server));



