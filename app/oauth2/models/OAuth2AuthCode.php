<?php

namespace App\Oauth2\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class OAuth2AuthCode extends Model {

    protected $table = 'oauth2_auth_codes';

    protected $primaryKey = 'id';

    protected $fillable = ['client_id', 'auth_code', 'user_identifier', 'expiry', 'scopes', 'revoked'];

    public $timestamps = false;
}