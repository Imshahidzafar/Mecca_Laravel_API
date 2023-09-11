<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dummytable1 extends Model
{
	protected $table="dummy_table";
	protected $fillable = [
        'cat_name',
         'date_added',
         'status'         ];
    protected $primaryKey = 'cat_id';
    public $timestamps = false; 
}