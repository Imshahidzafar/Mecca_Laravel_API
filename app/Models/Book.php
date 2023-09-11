<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $table="books";

    protected $fillable = ['categories_id','authors_id','title','book_url'];

    protected $primaryKey = 'books_id';
    public $timestamps = false;

    public function author()
    {
        return $this->hasOne(Author::class,'authors_id','authors_id');
    }
    
    public function category()
    {
        return $this->hasOne(Category::class,'categories_id','categories_id');
    }

}