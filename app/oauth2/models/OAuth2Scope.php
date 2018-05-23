<?php

namespace App\Oauth2\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class OAuth2Scope extends Model {

    // protected $connection = 'db1';
    
    protected $table = 'oauth2_scopes';

    protected $primaryKey = 'id';

    protected $fillable = ['parent_scope', 'scope', 'description'];

    public $timestamps = false;
}