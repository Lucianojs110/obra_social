<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Provincia extends Model

{

    protected $table = 'provincias';



    public function beneficiario()

    {

    	return $this->hasMany('App\Beneficiario', 'id_provincia', 'id');

    }

        public function user()

    {

    	return $this->belongsTo('App\User', 'id_provincia', 'id');

    }



}

