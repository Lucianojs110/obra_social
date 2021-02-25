<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';
    public function userenvia()
    {

        return $this->belongsTo('App\User', 'id_envia', 'id');

    }
    public function userrecibe()
    {

        return $this->belongsTo('App\User', 'id_recibe', 'id');

    }
}
