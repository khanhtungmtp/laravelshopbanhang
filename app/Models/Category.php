<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';

    protected $fillable = ['name', 'slug', 'status'];

    // xem category co nhung producttype nao
    public function productType()
    {
        return $this->hasMany('App\Models\ProductType', 'idCategory', 'id');
    }
}
