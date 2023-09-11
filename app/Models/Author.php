<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	protected $table="authors";

    protected $fillable = ['name'];

    protected $primaryKey = 'authors_id';
    public $timestamps = false;

}