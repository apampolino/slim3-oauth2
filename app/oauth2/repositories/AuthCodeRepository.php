<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\OAuth2\Repositories;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use App\OAuth2\Entities\AuthCodeEntity;
use App\OAuth2\Models\OAuth2AuthCode;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        // Some logic to persist the auth code to a database
        $authorization_code = new OAuth2AuthCode;

        $authorization_code->auth_code = $authCodeEntity->getIdentifier();

        $authorization_code->user_identifier = $authCodeEntity->getUserIdentifier();

        $authorization_code->client_id = $authCodeEntity->getClient()->getIdentifier();

        $authorization_code->expiry = $authCodeEntity->getExpiryDateTime()->getTimestamp();

        $scopes = array();

        foreach($authCodeEntity->getScopes() as $scope) {

            $scopes[] = $scope->getIdentifier();
        }

        $authorization_code->scopes = implode(",", $scopes);
        
        $authorization_code->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        // Some logic to revoke the auth code in a database
        $authorization_code = OAuth2AuthCode::where(['auth_code' => $codeId])->first();

        $authorization_code->revoked = 1;

        $authorization_code->save();
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        $authorization_code = OAuth2AuthCode::where(['auth_code' => $codeId])->first();

        if ($authorization_code->revoked == 1) {

            return true;
        
        } else {

            return false; // The auth code has not been revoked
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }
}
