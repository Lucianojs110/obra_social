<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Planilla extends Model

{

    protected $table = 'planilla';



    public function obrasocial()

    {

    	return $this->belongsTo('App\ObraSocial', 'id_obrasocial', 'id');

    }



     public function prestacion()

    {

    	return $this->belongsTo('App\Prestacion', 'id_prestacion', 'id');

    }



}

