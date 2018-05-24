<?php

namespace App\Oauth2\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class OAuth2RefreshToken extends Model {
    
    // protected $connection = 'db1';

    protected $table = 'oauth2_refresh_tokens';

    protected $primaryKey = 'id';

    protected $fillable = ['refresh_token', 'access_token', 'expiry', 'revoked'];

    public $timestamps = false;
}