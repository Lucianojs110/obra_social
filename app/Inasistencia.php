<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inasistencia extends Model
{
    protected $table = 'inasistencias';

    public function beneficiario()
    {
        return $this->belongsTo('App\Beneficiario', 'beneficiario_id', 'id');
    }
}
