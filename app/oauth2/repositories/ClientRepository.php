<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\OAuth2\Repositories;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use App\OAuth2\Entities\ClientEntity;
use App\Oauth2\Models\OAuth2Client;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true)
    {
        $client = Oauth2Client::where('client_id', $clientIdentifier)->first();

        if ($client) {

            if ($mustValidateSecret === true && $client->is_confidential == 1 && password_verify($clientSecret, $client->client_secret) === false) {

                return;
            }

            $client = new ClientEntity();
            $client->setIdentifier($clientIdentifier);
            $client->setName($client->app_name);
            $client->setRedirectUri($client->redirect_uri);

            return $client;

        } else {

            return;
        }
    }
}
