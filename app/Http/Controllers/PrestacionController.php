<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Prestacion;

use App\Prestador;

use App\Beneficiario;



class PrestacionController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    { //SELECCIONO SI LA OBRA SOCIAL USA NOMENCLADOR
         $obrasocial = \DB::select("SELECT nomenclador FROM obrasocial WHERE id = " . $id );
         date_default_timezone_set('America/Argentina/Buenos_Aires');
        if(is_array($obrasocial)){
            if($obrasocial[0]->nomenclador){
            $fecha = date("Y-m-d");   
            $query= "SELECT p.id,p.nombre,p.descripcion,c.nombre as categoria,n.id as nomenclador FROM prestacion_nomenclador as pn LEFT JOIN prestacion as p ON pn.id_prestacion=p.id LEFT JOIN categorias as c on p.id_categoria=c.id LEFT JOIN nomenclador as n ON pn.id_nomenclador=n.id WHERE n.fecha_inicio<='$fecha' and n.fecha_fin>='$fecha' and p.id!='null' ORDER BY p.orden ASC";          
              $prestacion = \DB::select($query);
        //$prestacion = Prestacion::where('os_id', $id)->with('categoria')->get();

                return $prestacion;
            }else{
                 $prestacion = \DB::select("SELECT p.id,p.nombre,c.nombre as categoria FROM prestacion as p LEFT JOIN categorias as c on p.id_categoria=c.id WHERE p.os_id = " . $id );

        //$prestacion = Prestacion::where('os_id', $id)->with('categoria')->get();

                return $prestacion;

            }
        }
           

         exit;
 

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        // Borro prestacion

        $prestacion = Prestacion::find($id);

        $prestacion->delete();



        // Borro prestaciones asociadas en datos de prestador

        $prestador = Prestador::where('prestacion_id', $id);



        // Busco beneficiarios asociados y los elimino tambien

        foreach($prestador as $prest){

            $beneficiarios = Beneficiario::where('prestador_id', $prest->id);

            $beneficiarios->delete();       

        }

         

        // Elimino prestador

        $prestador->delete();



         return redirect()->route('prestaciones')

            ->with(['message' => 'La prestacion con sus datos de prestador y beneficiarios asociados han sido eliminados correctamente']);

    }

   
    

}

