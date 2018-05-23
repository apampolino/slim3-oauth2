<?php

namespace App\OAuth2;

use \Psr\Container\ContainerInterface;
use \League\OAuth2\Server\AuthorizationServer;
use \App\OAuth2\Repositories\AccessTokenRepository;

class SlimOAuth2Secure {
    
    public $server;

    public function __construct(ContainerInterface $container) {

        // Init our repositories
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface

        // Path to authorization server's public key
        $publicKeyPath = __DIR__ . '/../../keys/public.key';
                
        // Setup the authorization server
        $this->server = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );

        return $this->server;
    }
}