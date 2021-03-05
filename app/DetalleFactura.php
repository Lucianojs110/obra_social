<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detalle_factura';

    protected $primaryKey = 'id_detalle';


    protected $fillable =[

        'cantidad',
        'prestacion_nombre',
        'valor_modulo',
        'subtotal',
        'id_factura',
       
    ];

    public function factura(){
        return $this->belongsTo('App\Facturas', 'id_factura', 'id_factura');
    }

    
}




    




