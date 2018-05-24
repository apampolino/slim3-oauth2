<?php

namespace App\Oauth2\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class OAuth2Client extends Model {
    
    protected $table = 'oauth2_clients';

    protected $primaryKey = 'id';

    protected $fillable = ['client_id', 'client_secret', 'app_name', 'redirect_uri', 'is_confidential'];

    public $timestamps = true;
}