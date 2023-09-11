<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookView extends Model
{
	protected $table="books_views";

    protected $fillable = ['users_customers_id','books_id'];

    protected $primaryKey = 'books_views_id';
    public $timestamps = false;

}