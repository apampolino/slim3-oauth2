<?php

namespace App\Oauth2\Models;

use Illuminate\Database\Eloquent\Model;

class OAuth2User extends Model {
    
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = ['uid', 'username', 'password', 'role'];

    public $timestamps = true;
}