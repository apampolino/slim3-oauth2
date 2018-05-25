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

    protected $settings;

    public $server;

    public $middleware;

    public function __construct(ContainerInterface $container, Array $settings) {

        $this->container = $container;
        // Load eloquent
        $this->container->eloquent;

        $this->settings = $settings;

        $this->initServer();

        $this->initMiddleware();
    }

    public function initServer() {

        $clientRepository = new ClientRepository(); // instance of ClientRepositoryInterface
        $scopeRepository = new ScopeRepository(); // instance of ScopeRepositoryInterface
        $authCodeRepository = new AuthCodeRepository();
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface
        $refreshTokenRepository = new RefreshTokenRepository();
        $userRepository = new UserRepository();

        // Path to public and private keys
        $privateKey =  new CryptKey($this->settings['private_key_path'], $this->settings['private_key_pass']);

        $encryptionKey = $this->settings['encryption_key']; // generate using base64_encode(random_bytes(32))

        // Setup the authorization server
        $this->server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        foreach ($this->settings['grants'] as $key => $grant) {

            if ($grant['enabled'] && $key == 'authorization_code') {

                $authorization = new \League\OAuth2\Server\Grant\AuthCodeGrant(
                     $authCodeRepository,
                     $refreshTokenRepository,
                     new \DateInterval($grant['authorization_code_expiry']) // authorization codes will expire after 10 minutes
                 );

                $authorization->setRefreshTokenTTL(new \DateInterval($grant['refresh_token_expiry'])); // refresh tokens will expire after 1 month

                // Enable the authentication code grant on the server
                $this->server->enableGrantType(
                    $authorization,
                    new \DateInterval($grant['access_token_expiry']) // access tokens will expire after 1 hour
                );
            }

            if ($grant['enabled'] && $key == 'password') {

                $password_grant = new \League\OAuth2\Server\Grant\PasswordGrant(
                         $userRepository,
                         $refreshTokenRepository
                );

                $password_grant->setRefreshTokenTTL(new \DateInterval($grant['refresh_token_expiry'])); // refresh tokens will expire after 1 month
                
                // Enable the password grant on the server
                $this->server->enableGrantType(
                    $password_grant,
                    new \DateInterval($grant['access_token_expiry']) // new access tokens will expire after an hour
                );
            }

            if ($grant['enabled'] && $key == 'client_credentials') {

                //Enable the client credentials grant on the server
                $this->server->enableGrantType(
                    new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
                    new \DateInterval($grant['access_token_expiry']) // access tokens will expire after 1 hour
                );
            }

            if ($grant['enabled'] && $key == 'refresh_token') {

                $refresh_token = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);

                $refresh_token->setRefreshTokenTTL(new \DateInterval($grant['refresh_token_expiry'])); // new refresh tokens will expire after 1 month

                // Enable the refresh token grant on the server
                $this->server->enableGrantType(
                    $refresh_token,
                    new \DateInterval($grant['access_token_expiry']) // new access tokens will expire after an hour
                );
            }

            if ($grant['enabled'] && $key == 'implicit') {

                // Enable the implicit grant on the server
                $this->server->enableGrantType(
                    new ImplicitGrant(new \DateInterval($grant['implicit_expiry'])),
                    new \DateInterval($grant['access_token_expiry']) // access tokens will expire after 1 hour
                );
            }
        }
    }

    public function initMiddleware() {

        // Init our repositories
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface

        // Path to authorization server's public key
        $publicKeyPath = $this->settings['public_key_path'];
                
        // Setup the authorization server
        $this->middleware = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
    }
}