<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';

    protected $fillable = ['idUser', 'email', 'address','phone', 'active'];

    //    dia chi cua user nao
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'idUser', 'id');
    }
}
