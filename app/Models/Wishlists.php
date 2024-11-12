<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlists extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['title', 'author', 'genre', 'notes'];
}
