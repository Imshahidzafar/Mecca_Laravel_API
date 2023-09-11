<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
	protected $table="bookmark_books";

    protected $fillable = ['users_customers_id','books_id'];

    protected $primaryKey = 'bookmark_books_id';
    public $timestamps = false;

}