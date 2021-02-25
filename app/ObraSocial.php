<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $table = 'obrasocial';

    public function prestador()
    {
    	return $this->belongsTo('App\Prestador');
    }

    public function prestacion()
    {
    	return $this->hasMany('App\Prestacion');
    }

}
