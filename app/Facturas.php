<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;


    protected $fillable =[

        'cbteFch',
        'tipoCbteNumero',
        'nroCbte',
        'caeNum',
        'caeFvto',
        'docTipo',
        'docNro',
        'nombreRS',
        'tipoPago',
        'impNeto',
        'impIVA',
        'impTotal',
        'cbteAsoc',
        'codigoQr',
        'servicios',
        'concepto',
        'fdesde',
        'fhasta',
        'fvtopag',
        'user_id',
        'os_id',

       
    ];

    public function User(){
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
