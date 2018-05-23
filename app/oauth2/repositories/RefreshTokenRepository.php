<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\OAuth2\Repositories;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use App\OAuth2\Entities\RefreshTokenEntity;
use App\OAuth2\Models\OAuth2RefreshToken;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntityInterface)
    {
        // Some logic to persist the refresh token in a database
        $refresh_token = new OAuth2RefreshToken;

        $refresh_token->refresh_token = $refreshTokenEntityInterface->getAccessToken()->getIdentifier();

        $refresh_token->token_id = $refreshTokenEntityInterface->getIdentifier();

        $refresh_token->expiry = $refreshTokenEntityInterface->getExpiryDateTime()->getTimestamp();

        $refresh_token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        // Some logic to revoke the refresh token in a database
        $refresh_token = OAuth2RefreshToken::where(['token_id' => $tokenId])->first();

        $refresh_token->revoked = 1;

        $refresh_token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $refresh_token = OAuth2RefreshToken::where(['token_id' => $tokenId])->first();

        if ($refresh_token->revoked == 1) {

            return true;
        
        } else {

            return false; // The refresh token has not been revoked
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
