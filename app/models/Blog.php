<?php

namespace App\Models;

use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

    protected $table = 'blogs';

    protected $primaryKey = 'id';

    protected $fillable = [''];

    public $timestamps = true;
}