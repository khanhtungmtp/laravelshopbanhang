<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $fillable = ['name', 'slug', 'image', 'description', 'quantity', 'price', 'promotional', 'idCategory', 'idProductType', 'status'];

    public function productType()
    {
        return $this->belongsTo('App\Models\ProductTypes', 'idProductType', 'id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Categories', 'idCategory', 'id');
    }
}
