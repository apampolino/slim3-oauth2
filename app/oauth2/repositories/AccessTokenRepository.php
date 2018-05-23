<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\OAuth2\Repositories;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use App\OAuth2\Entities\AccessTokenEntity;
use App\OAuth2\Models\OAuth2AccessToken;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        // Some logic here to save the access token to a database

        $oauth_access_token = new OAuth2AccessToken;

        $oauth_access_token->access_token = $accessTokenEntity->getIdentifier();
        $oauth_access_token->user_identifier = $accessTokenEntity->getUserIdentifier();
        $oauth_access_token->client_id = $accessTokenEntity->getClient()->getIdentifier();
        $oauth_access_token->expiry = $accessTokenEntity->getExpiryDateTime()->getTimestamp();

        $scopes = array();

        foreach($accessTokenEntity->getScopes() as $scope) {

            $scopes[] = $scope->getIdentifier();
        }

        $oauth_access_token->scopes = implode(",", $scopes);
        $oauth_access_token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        // Some logic here to revoke the access token
        $access = OAuth2AccessToken::where(['access_token' => $tokenId])->first();

        $access->revoked = 1;

        $access->save();
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $access = OAuth2AccessToken::where(['access_token' => $tokenId]);

        if ($access->revoked == 1) {

            return true;
        
        } else {
            
            return false; // Access token hasn't been revoked
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();

        $accessToken->setClient($clientEntity);

        foreach ($scopes as $scope) {

            $accessToken->addScope($scope);
        }
        
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }
}
