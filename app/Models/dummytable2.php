<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dummytable2 extends Model
{
	protected $table="dummy_table2";
	protected $fillable = [
        'product_id',
		'cat_id',
        'product_name',
         'date_added',
         'status'         ];
    protected $primaryKey = 'product_id';
    public $timestamps = false; 
}