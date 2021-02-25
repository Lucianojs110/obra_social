<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use App\User;

use App\ObraSocial;

use App\Prestador;

use App\Prestacion;





class ObraSocialController extends Controller

{

	public function __construct()

    {

        $this->middleware('auth');

    }



   	public function index()

   	{

         // Devuelvo vista obra social

         $user_id = \Auth::user()->id;



        $prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();

   		$os = ObraSocial::orderBy('id', 'asc')->get();

   		return view('obrasocial', [

   			'os' => $os,

            'prestador_menu' => $prestador_menu,

   		]);

   	}



   	public function create(Request $request)

   	{

         // Creo obra social

   		$validate = $this->validate($request,[

   			'cuit' => ['required', 'max:45']

   		]);



   		// Creo objeto de OS

   		$os = new ObraSocial;



   		// Datos de input

   		$nombre = $request->input('nombre');

         $tipo = $request->input('tipoObra');

   		$cuit = $request->input('cuit');

   		$ciudad = $request->input('ciudad');

   		$direccion = $request->input('direccion');

   		$telefono = $request->input('telefono');

   		$email = $request->input('email');

   		$condicion_iva = $request->input('condicionIva');

   		$valor_sesion = $request->input('valorSesion');

   		$valor_km = $request->input('valorKm');

   		$valor_modulo = $request->input('valorModulo');

         $nomenclador = $request->input('nomenclador');

   		// Asigno objeto relacionado a inputs

   		$os->nombre = $nombre;

         $os->tipo_obra = $tipo;

   		$os->cuit = $cuit;

   		$os->telefono = $telefono;

   		$os->ciudad = $ciudad;

   		$os->direccion = $direccion;

   		$os->email = $email;

   		$os->condicion_iva = $condicion_iva;

   		$os->valor_sesion = $valor_sesion;

   		$os->valor_km = $valor_km;

   		$os->valor_modulo = $valor_modulo;

   		$os->valor_mes = 'Definir';

         $os->nomenclador = $nomenclador;



   		//Guardo en BBDD

   		$os->save();



   		return redirect()->route('obra-social')->with(['message' => 'La obra social ha sido guardada correctamente']);

   	}



   	public function list(Request $request)

   	{

         // Muestro obra social

   		$os = ObraSocial::find($request->id);

   		return $os;

   	}



   	public function update(Request $request)

   	{

         // Actualizo obra social

   		$validate = $this->validate($request,[

   			'editarCuit' => ['required', 'max:45']

   		]);



   		// Creo objeto de OS

   		$os = ObraSocial::find($request->id);



   		// Datos de input

   		$nombre = $request->input('editarNombre');

         $tipo = $request->input('editarTipoObra');

   		$cuit = $request->input('editarCuit');

   		$ciudad = $request->input('editarCiudad');

   		$direccion = $request->input('editarDireccion');

   		$telefono = $request->input('editarTelefono');

   		$email = $request->input('editarEmail');

   		$condicion_iva = $request->input('editarCondicionIva');

   		$valor_sesion = $request->input('editarValorSesion');

   		$valor_km = $request->input('editarValorKm');

   		$valor_modulo = $request->input('editarValorModulo');

         $nomenclador = $request->input('editarnomenclador');


   		// Asigno objeto relacionado a inputs

   		$os->nombre = $nombre;

         $os->tipo_obra = $tipo;

   		$os->cuit = $cuit;

   		$os->telefono = $telefono;

   		$os->ciudad = $ciudad;

   		$os->direccion = $direccion;

   		$os->email = $email;

   		$os->condicion_iva = $condicion_iva;

   		$os->valor_sesion = $valor_sesion;

   		$os->valor_km = $valor_km;

   		$os->valor_modulo = $valor_modulo;

   		$os->valor_mes = 'Definir';

         $os->nomenclador = $nomenclador;


   		//Guardo en BBDD

   		$os->save();



   		return redirect()->route('obra-social')->with(['message' => 'La obra social ha sido editada correctamente']);

   	}



      public function lista_prestaciones()

      {

         // Devuelvo vista prestaciones

         $user_id = \Auth::user()->id;



         $prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();



         // Devuelvo prestaciones

         $prestaciones = Prestacion::with('obrasocial')->get();



         // Devuelvo Obras Sociales

         $os = ObraSocial::orderBy('id', 'asc')->get();



         return view('prestaciones', [

            'prestador_menu' => $prestador_menu,

            'prestaciones' => $prestaciones,

            'obras_sociales' => $os,

         ]);

      }



      public function create_prestacion(Request $request)

      {

         $prestacion = new Prestacion;



         $nombre_prestacion = $request->input('prestacion');

         $obra_social = $request->input('obra_social');

         $codigo_modulo = $request->input('codigo_modulo');

         $valor_modulo = $request->input('valor_prestacion');

         $planilla = $request->input('planilla');



         $prestacion->nombre_pres = $nombre_prestacion;

         $prestacion->os_id = $obra_social;

         $prestacion->codigo_modulo = $codigo_modulo;

         $prestacion->valor_modulo = $valor_modulo;

         $prestacion->planilla = $planilla;



         $prestacion->save();



         return redirect()->route('prestaciones')->with(['message' => 'La prestacion ha sido guardada correctamente']);

      }



      public function edit(Request $request)

      {

         $prestacion = Prestacion::find($request->input('id'));





         $obra_social = $request->input('obra_social');

         $codigo_modulo = $request->input('codigo_modulo');

         $nombre_prestacion = $request->input('prestacion');

         $valor_modulo = $request->input('valor_prestacion');

         $planilla = $request->input('planilla');



         $prestacion->nombre = $nombre_prestacion;

         $prestacion->os_id = $obra_social;

         $prestacion->codigo_modulo = $codigo_modulo;

         $prestacion->valor_modulo = $valor_modulo;

         $prestacion->planilla = $planilla;



         $prestacion->save();



         return redirect()->route('prestaciones')->with(['message' => 'La prestacion ha sido editada correctamente']);

      }



      public function show($id)

      {

         $prestacion = Prestacion::where('id', $id)->get();

         return $prestacion;

      }

}

