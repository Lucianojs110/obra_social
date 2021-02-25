<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesion';

    public function beneficiario()
    {
    	return $this->belongsTo('\App\Beneficiario', 'beneficiario_id', 'id');
    }
}
