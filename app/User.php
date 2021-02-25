<?php



namespace App;



use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable

{

    use Notifiable;



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'surname', 'email', 'role', 'password', 'banned_until',

    ];
    protected $dates = [
        'banned_until'
    ];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];



    /**

     * The attributes that should be cast to native types.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];



    public function prestador()

    {

        return $this->hasMany('App\Prestador');

    }

    public function facturacionelectronicacertificado()

    {

        return $this->hasMany('App\FacturacionElectronicaCertificado');

    }
    public function provincia()

    {

        return $this->belongsTo('App\Provincia', 'id_provincia', 'id');

    }
    public function mensajerecibido()

    {

        return $this->hasMany('App\Mensaje', 'id_recibe', 'id');

    }
    public function mensajeenviado()

    {

        return $this->hasMany('App\Mensaje', 'id_envia', 'id');

    }
}

