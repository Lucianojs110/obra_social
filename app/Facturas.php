<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    protected $table = 'facturas';

    protected $primaryKey = 'id_factura';


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
        'codigoBarra',
        'servicios',
        'concepto',
        'fdesde',
        'fhasta',
        'fvtopag',
        'user_id',
        'os_id',

       
    ];
}
