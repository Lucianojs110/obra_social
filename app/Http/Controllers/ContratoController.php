<?php



namespace App\Http\Controllers;



//use App\Contrato;

use Illuminate\Http\Request;



class ContratoController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $userId = \Auth::user()->id;



        //Prestador_menu

        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $userId . " GROUP BY obrasocial.id, obrasocial.nombre");



        //$Contratos = Contrato::all();
        $Contratos = scandir(public_path('uploads')."/contrato/", 1);
        return view('contrato', [

            'contrato' => $Contratos,

            'prestador_menu' => $prestador_menu,

        ]);

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

        // Creo obra social

        $validate = $this->validate($request,[
            'file' => 'mimes:pdf|max:2048',

        ]);



       // $Contrato = new Contrato;

       if($request->hasFile('file')){

        if($request->file->extension()){
            $fileName = 'contrato.pdf';  
       
            $request->file->move(public_path('uploads')."/contrato/", $fileName);

 
        }
        return redirect()->route('contrato')->with(['message' => 'Los datos del Contrato han sido guardados correctamente']);
    } else {
        return redirect()->route('contrato')->with(['message' => 'Seleccione un archivo']);
    }



            

 



    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Contrato  $Contrato

     * @return \Illuminate\Http\Response

     */

    public function show(Contrato $Contrato)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Contrato  $Contrato

     * @return \Illuminate\Http\Response

     */

    public function edit(Contrato $Contrato)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Contrato  $Contrato

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request)

    {    $validate = $this->validate($request,[

            'description' => ['required', 'max:255'],
            'file' => 'mimes:pdf|max:2048',

        ]);

        //$id = $request['id'];

        //$Contrato = Contrato::find($id);


         if($request->hasFile('file')){
            $this->borrar();
            $fileName ='contrato.pdf';  
       
            $request->file->move(public_path('uploads'), $fileName);
        }

            return redirect()->route('contrato')->with(['message' => 'Los datos del Contrato han sido editados correctamente']);



    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Contrato  $Contrato

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

            $this->borrar();

            return redirect()->route('contrato')->with(['message' => 'El Contrato ha sido eliminado correctamente']);


    }

    public function borrar(){
        $Contratos = scandir(public_path('uploads')."/contrato/", 1);
        $cantidad = count($Contratos);
        for ($i=0; $i < $cantidad ; $i++) { 

            if(strlen($Contratos[$i])>2){

                @unlink(public_path('uploads')."/contrato/".$Contratos[$i]);
            }
            # code...
        }

    }

    public function list(Request $request)

    {


        $Contratos = scandir(public_path('uploads')."/contrato/", 1);

        return json_encode($Contratos);

    }

}

