<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/blog', function(){

    $this->get('', \App\Controllers\BlogController::class . ':index');
    $this->get('/create', \App\Controllers\BlogController::class . ':create');
    $this->get('/{id}', \App\Controllers\BlogController::class . ':show');
    $this->get('/{id}/edit', \App\Controllers\BlogController::class . ':edit');
    $this->post('', \App\Controllers\BlogController::class . ':store');
    $this->put('/{id}/update', \App\Controllers\BlogController::class . ':update');
    $this->delete('/{id}/delete', \App\Controllers\BlogController::class . ':delete');
});

$app->group('/users', function() {

    $this->get('', function(Request $request, Response $response, array $args) {

        return $response;
    });

    $this->get('/{id}', function(Request $request, Response $response, array $args) {

        return $response;
    });

})->add(new \League\OAuth2\Server\Middleware\ResourceServerMiddleware($container->get('oauth2')->middleware));

$app->group('/oauth2', function () {

    $this->get('', \App\Controllers\Oauth2Controller::class . ':index');

    $this->get('/authorize', \App\Controllers\Oauth2Controller::class . ':authorize');

    $this->post('/access_token', \App\Controllers\Oauth2Controller::class . ':access_token');
});

