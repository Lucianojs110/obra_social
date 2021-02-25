<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Prestador extends Model

{

    protected $table = 'prestador';



    public function user()

    {

        return $this->belongsTo('App\User', 'user_id', 'id');

    }



    public function obrasocial()

    {

    	return $this->hasMany('App\ObraSocial', 'id', 'os_id');

    }



    /* public function beneficiario()

     {

     	return $this->hasMany('App\Beneficiario', 'prestador_id', 'id')->leftJoin('traditum', 'beneficiario_id', 'beneficiario.id')->select('beneficiario.*', 'traditum.codigo', 'traditum.mes', 'traditum.anio')->orderBy('nombre', 'desc');

     }
*/


    public function beneficiario()

    {



      return $this->hasMany('App\Beneficiario', 'prestador_id', 'id')->where(\DB::raw('DATE_FORMAT(CAST(created_at as DATE), "%Y-%m")'), '<=', \Auth::user()->anio.'-'.\Auth::user()->mes)
->where('deleted_at',null)
->where('activo', 1)
->orwhere(function($query){

			$query
            ->where(\DB::raw('DATE_FORMAT(CAST(fecha_inactivo as DATE), "%Y-%m")'), '>', \Auth::user()->anio.'-'.\Auth::user()->mes)
                ->where(\DB::raw('DATE_FORMAT(CAST(created_at as DATE), "%Y-%m")'), '<=', \Auth::user()->anio.'-'.\Auth::user()->mes)
				->where('activo', 0)
                ->where('deleted_at',null);

				

		})
		->orderBy('nombre');
       /* echo \Auth::user()->anio.'-'.\Auth::user()->mes.'-01';
        return $this->hasMany('App\Beneficiario', 'prestador_id', 'id')->where('created_at', '>=', \Auth::user()->anio.'-'.\Auth::user()->mes.'-01 00:00:00')
        //->where('activo', 1)
        ->where('fecha_inactivo', '<', \Auth::user()->anio.'-'.\Auth::user()->mes."-01")
        ->where('deleted_at',null)
        /*->orwhere(function($query) {
                $query->where('created_at', '>=', \Auth::user()->anio.'-'.\Auth::user()->mes.'-01 00:00:00')
                      ->where('fecha_inactivo', '=', null)
                       ->where('deleted_at',null);
            })
        //->where('activo', 1)
        //->where('activo', 0)
      
        ->withTrashed()->orderBy('nombre'); */



	}

	

	public function beneficiarioInactivo()

    {

        return $this->hasMany('App\Inactivo',  'id','id_ben');

    }



    public function prestacion()

    {

        return $this->hasMany('App\Prestacion', 'id', 'prestacion_id');

    }

    public function beneficiarios()

    {
        return $this->hasMany('App\Beneficiario', 'prestador_id', 'id');
    }

}

