<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traditum extends Model
{
    protected $table = 'traditum';

    public function beneficiario()
    {
    	return $this->belongsTo('App\Beneficiario', 'beneficiario_id', 'id');
    }
}
