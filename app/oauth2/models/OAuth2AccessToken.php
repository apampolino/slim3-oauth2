<?php

namespace App\Oauth2\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class OAuth2AccessToken extends Model {
    
    // protected $connection = 'db1';

    protected $table = 'oauth2_access_tokens';

    protected $primaryKey = 'id';

    protected $fillable = ['client_id', 'access_token', 'user_identifier', 'expiry', 'scopes', 'revoked'];

    public $timestamps = false;
}