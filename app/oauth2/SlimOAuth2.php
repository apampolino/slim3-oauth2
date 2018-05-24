<?php

namespace App\OAuth2;

use \Psr\Container\ContainerInterface;
use \League\OAuth2\Server\AuthorizationServer;
use \League\OAuth2\Server\CryptKey;
use \League\OAuth2\Server\Grant\ImplicitGrant;
use \App\OAuth2\Repositories\ClientRepository;
use \App\OAuth2\Repositories\ScopeRepository;
use \App\OAuth2\Repositories\AuthCodeRepository;
use \App\OAuth2\Repositories\AccessTokenRepository;
use \App\OAuth2\Repositories\RefreshTokenRepository;
use \App\OAuth2\Repositories\UserRepository;

class SlimOauth2 {

    protected $container;

    public $server;

    public $middleware;

    public function __construct(ContainerInterface $container) {

        $this->container = $container;
        // Load eloquent
        $this->container->eloquent;

        $this->loadOauthServer();

        $this->loadServerMiddleware();
    }

    public function loadOauthServer() {

        $clientRepository = new ClientRepository(); // instance of ClientRepositoryInterface
        $scopeRepository = new ScopeRepository(); // instance of ScopeRepositoryInterface
        $authCodeRepository = new AuthCodeRepository();
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface
        $refreshTokenRepository = new RefreshTokenRepository();
        $userRepository = new UserRepository();

        // Path to public and private keys
        $privateKey =  new CryptKey(__DIR__ . '/../../keys/private.key', 'test1234');

        $encryptionKey = 'aNVLDla5uO8K5q4cZlBQtDgIq9lYnbM9PuH0DK2Nd3g='; // generate using base64_encode(random_bytes(32))

        // Setup the authorization server
        $this->server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        //Enable the client credentials grant on the server
        $this->server->enableGrantType(
            new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );

        $authorization = new \League\OAuth2\Server\Grant\AuthCodeGrant(
             $authCodeRepository,
             $refreshTokenRepository,
             new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
         );

        $authorization->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

        // Enable the authentication code grant on the server
        $this->server->enableGrantType(
            $authorization,
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );

        $refresh_token = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);

        $refresh_token->setRefreshTokenTTL(new \DateInterval('P1M')); // new refresh tokens will expire after 1 month

        // Enable the refresh token grant on the server
        $this->server->enableGrantType(
            $refresh_token,
            new \DateInterval('PT1H') // new access tokens will expire after an hour
        );

        $password_grant = new \League\OAuth2\Server\Grant\PasswordGrant(
                 $userRepository,
                 $refreshTokenRepository
        );

        $password_grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month
        
        // Enable the password grant on the server
        $this->server->enableGrantType(
            $password_grant,
            new \DateInterval('PT1H') // new access tokens will expire after an hour
        );

        // Enable the implicit grant on the server
        $this->server->enableGrantType(
            new ImplicitGrant(new \DateInterval('PT1H')),
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );

    }

    public function loadServerMiddleware() {

        // Init our repositories
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface

        // Path to authorization server's public key
        $publicKeyPath = __DIR__ . '/../../keys/public.key';
                
        // Setup the authorization server
        $this->middleware = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
    }
}