<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers\SlimController;
use \App\OAuth2\Entities\UserEntity;

class Oauth2Controller extends SlimController {

    public function index(Request $request, Response $response, array $args) {

        $this->container->view->render($response, 'oauth2/index.html.twig');
    }

    public function authorize(Request $request, Response $response, array $args) {

        try {
        
            $server = $this->container->get('oauth2')->server;

            // Validate the HTTP request and return an AuthorizationRequest object.
            $authRequest = $server->validateAuthorizationRequest($request);
            
            // The auth request object can be serialized and saved into a user's session.
            // You will probably want to redirect the user at this point to a login endpoint.
            
            // Once the user has logged in set the user on the AuthorizationRequest
            $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface
            
            // At this point you should redirect the user to an authorization page.
            // This form will ask the user to approve the client and the scopes requested.
            
            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);
            
            // Return the HTTP redirect response
            return $server->completeAuthorizationRequest($authRequest, $response);
            
        } catch (OAuthServerException $exception) {
        
            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);
            
        } catch (\Exception $exception) {
        
            // Unknown exception
            // $body = new Stream(fopen('php://temp', 'r+'));
            $body = $response->getBody();

            $body->write($exception->getMessage());

            return $response->withStatus(500)->withBody($body);
        }
    }

    public function access_token(Request $request, Response $response, array $args) {

        // /* @var \League\OAuth2\Server\AuthorizationServer $server */
        // $server = $app->getContainer()->get(AuthorizationServer::class);
        $server = $this->container->get('oauth2')->server;

        try {
            // Try to respond to the request
            return $server->respondToAccessTokenRequest($request, $response);
            
        } catch (\League\OAuth2\Server\Exception\OAuthServerException $exception) {
        
            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);
            
        } catch (\Exception $exception) {
        
            // Unknown exception
            // $body = new Stream('php://temp', 'r+');
            $body = $response->getBody();

            $body->write($exception->getMessage());

            return $response->withStatus(500)->withBody($body);
        }
    }

    public function store(Request $request, Response $response, array $args) {

        // $params = $request->getParsedBody();

        // $blog = new Blog;

        // $blog->title = $params['title'];

        // $blog->body = $params['body'];

        // $blog->name = $params['name'];

        // $blog->email = $params['email'];

        // $blog->save();

        // return $response->withRedirect('/blog');
    }
}