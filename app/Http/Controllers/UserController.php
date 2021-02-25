<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Prestador;

use App\User;

use App\Beneficiario;

use App\ObraSocial;

use App\Sesion;



class UserController extends Controller

{

	public function __construct()

    {

        $this->middleware('auth');

    }



    public function update(Request $request)

    {   $iduser= $request->input('iduser');
        if((int)$iduser>0){
            $id = $iduser;
            $user = User::find($id);
            $redir =1;
        } else{
            $user = \Auth::user();

            $id = $user->id;
            $redir =0;

        }

        



        // Valido campos

        $validate = $this->validate($request, [

        	'direccion' => ['max:100'],

        	'telefono' => ['max:45'],

        	'cuit' => ['max:50'],

        ]);



        // Datos de inputs

        $direccion = $request->input('direccion');

        $provincia = $request->input('provincia');

        $telefono = $request->input('telefono');

        $cuit = $request->input('cuit');

        $condicion_iva = $request->input('condicionIva');

        $condicion_iibb = $request->input('condicionIibb');

        $iibb = $request->input('iibb');

        $entidadBancaria = $request->input('entidadBancaria');

        $cbu = $request->input('cbu');

        $ordenCheque = $request->input('ordenCheque');

        $lugarPago = $request->input('lugarPago');

        $empSeguros = $request->input('empSeguros');

        $poliza = $request->input('polSeguros');
        $localidad = $request->input('localidad');





        // Asigno valores al objeto usuario

        $user->direccion = $direccion;

        $user->id_provincia = $provincia;

        $user->telefono = $telefono;

        $user->cuit = $cuit;

        $user->condicion_iva = $condicion_iva;

        $user->condicion_iibb = $condicion_iibb;

        $user->iibb = $iibb;

        $user->entidad_bancaria = $entidadBancaria;

        $user->cbu = $cbu;

        $user->orden_cheque = $ordenCheque;

        $user->lugar_pago = $lugarPago;

        $user->emp_seguros = $empSeguros;

        $user->poliza = $poliza;
        $user->localidad = $localidad;



        // Query            

        $user->update();


        if($redir){
            return redirect()->route('admin-users')->with(['message' => 'Usuario actualizado correctamente']);

        }else{
            return redirect()->route('home')->with(['message' => 'Usuario actualizado correctamente']);
        }
        

    }

    public function bloquear($id){
       if(\Auth::user()->id==1){
           $user = User::find($id);
           $user->banned_until = date("Y-m-d H:i:s");
           $user->update();
            return redirect()->route('admin-users')->with(['message' => 'El usuario ha sido bloqueado'])    ; 
        }

    }
    public function desbloquear($id){
       if(\Auth::user()->id==1){
           $user = User::find($id);
           $user->banned_until = null;
           $user->update();
            return redirect()->route('admin-users')->with(['message' => 'El usuario ha sido desbloqueado'])    ; 
        }

    }
    public function destroy($id)

    {

        $user = User::where('id', $id)->with('prestador','facturacionelectronicacertificado','mensajerecibido','mensajeenviado')->first();

        if($user->id == \Auth::user()->id){

            return back();


        }else{


            try {

                DB::beginTransaction();

                // Busco prestador para eliminar con sus registros

                foreach($user->prestador as $pres){

                    $pres->delete();

                }
                // Busco prestador para eliminar con sus facturacionelectronicacertificado

                foreach($user->facturacionelectronicacertificado as $fac){

                    $fac->delete();

                }
                // Busco mensajes recibidos para eliminar

                foreach($user->mensajerecibido as $msgr){

                    $msgr->delete();

                }
                // Busco mensajes enviados para eliminar

                foreach($user->mensajeenviado as $msge){

                    $msge->delete();

                }

                $user->delete();

                DB::commit();

                return redirect()->route('admin-users')->with(['message' => 'El usuario ha sido eliminado correctamente'])    ;   

            } catch (\Throwable $th) {

                return back();


            }

        }

    }

    public function showSystemUsers()

    {

        $users = User::all();

        $user_id = \Auth::user()->id;

        $prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();

        return view('users', [

            'users' => $users,

            'prestador_menu' => $prestador_menu

        ]);

    }



    public function saveUserMonth(Request $request)

    {

        // Consulto si el prestador quiere ver algun mes en particular y lo asigno a su usuario

        // De esta forma si cierra la sesion y la vuelve a abrir queda el mes y año grabado

        $prestador = User::where('id', \Auth::user()->id)->first();

        $prestador->mes = $request['mes'];

        $prestador->save(); 



        // return redirect()->route('beneficiarios', [

        //     'prestador_id' => $request['idPrest'],

        //     'obrasocial_id' => $request['idOs'],

        //     'mes' => \Auth::user()->mes,

        //     'anio' => \Auth::user()->anio,

        // ])->with(['message' => 'Mes actualizado correctamente']);  



        return true;

	}

	

	public function saveUserYear(Request $request)

    {

        // Consulto si el prestador quiere ver algun año en particular y lo asigno a su usuario

        // De esta forma si cierra la sesion y la vuelve a abrir queda el mes y año grabado

        $prestador = User::where('id', \Auth::user()->id)->first();

        $prestador->anio = $request['anio'];

        $prestador->save(); 



        return true;

    }
    public function list(Request $request)

    {

        $id = $request['id'];

        $user = User::find($id);

        return json_encode($user);

    }


}

