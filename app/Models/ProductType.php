<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //
    protected $table = 'producttype';

    protected $fillable = ['idCategory', 'name', 'slug', 'status'];
}
