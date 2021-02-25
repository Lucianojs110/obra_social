<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificados extends Model
{
    use SoftDeletes;
    protected $table = 'afip_certificados';

    protected $primaryKey = 'id_certificado';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';


    protected $fillable =[

      'certkey',
      'certcrt',
      'ptovta',
      'id_user',
     
  ];

  public function users(){
    return $this->belongsTo('App\User', 'id_user', 'id');
  }

   
}
