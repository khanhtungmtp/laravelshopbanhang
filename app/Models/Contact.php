<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $table = 'contact';

    protected $fillable = ['idUser', 'message'];

    //    contact cua user nao
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'idUser', 'id');
    }
}
