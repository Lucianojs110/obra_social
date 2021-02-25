<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class Beneficiario extends Model

{

	use SoftDeletes; 

	protected $table = 'beneficiario';

	

    public function prestador()

    {

    	return $this->belongsTo('App\Prestador', 'prestador_id', 'id');

    }

	public function provincia()

    {

    	return $this->belongsTo('App\Provincia', 'id_provincia', 'id');

    }
    public function provinciaprestacion()

    {

    	return $this->belongsTo('App\Provincia', 'id_provincia_prestacion', 'id');

    }


    public function sesion()

    {

    	return $this->hasMany('App\Sesion', 'beneficiario_id', 'id');

    }

    public function inactivo()

    {

        return $this->hasMany('App\Inactivo', 'id_ben', 'id');

    }


    public function traditum()

    {

        return $this->hasMany('App\Traditum', 'id', 'beneficiario_id');

	}

	

	public function inasistencia()

	{

		return $this->hasMany('App\Inasistencia', 'beneficiario_id', 'id')->where(\DB::raw('DATE_FORMAT(CAST(created_at as DATE), "%Y-%m")'), '>=', \Auth::user()->anio.'-'.\Auth::user()->mes)->where('tipo', 'Inasistencia');

	}



	public function agregado()

	{

		return $this->hasMany('App\Inasistencia', 'beneficiario_id', 'id')->where(\DB::raw('DATE_FORMAT(CAST(created_at as DATE), "%Y-%m")'), '>=', \Auth::user()->anio.'-'.\Auth::user()->mes)->where('tipo', 'Agregado');

	}

}

