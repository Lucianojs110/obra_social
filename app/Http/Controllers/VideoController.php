<?php



namespace App\Http\Controllers;



use App\Video;

use Illuminate\Http\Request;



class VideoController extends Controller

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



        $videos = Video::all();

        return view('video-tutoriales', [

            'videos' => $videos,

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

            'description' => ['required', 'max:255'],
            'file' => 'mimes:pdf|max:2048',

        ]);



        $video = new Video;

        $video->description = $request['description'];

        $video->url_video = $request['url_video'];

       

        if($request->file->extension()){
            $fileName = time().'.'.$request->file->extension();  
       
            $request->file->move(public_path('uploads'), $fileName);

            $video->url_document = $fileName;
        }

        if($video->save()){

            return redirect()->route('video-tutorials')->with(['message' => 'Los datos del video han sido guardados correctamente']);

        }



    }



    /**

     * Display the specified resource.

     *

     * @param  \App\Video  $video

     * @return \Illuminate\Http\Response

     */

    public function show(Video $video)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Video  $video

     * @return \Illuminate\Http\Response

     */

    public function edit(Video $video)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Video  $video

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request)

    {    $validate = $this->validate($request,[

            'description' => ['required', 'max:255'],
            'file' => 'mimes:pdf|max:2048',

        ]);

        $id = $request['id'];

        $video = Video::find($id);



        $video->description = $request['description'];

        $video->url_video = $request['url_video'];

        $eliminarvideo = $request['eliminarvideo'];
        if($eliminarvideo){
            @unlink(public_path('uploads')."/".$video->url_document);
             $video->url_document = "";
        }

         if($request->hasFile('file')){
            @unlink(public_path('uploads')."/".$video->url_document);
            $fileName = time().'.'.$request->file->extension();  
       
            $request->file->move(public_path('uploads'), $fileName);

            $video->url_document = $fileName;
        }

        if($video->save()){

            return redirect()->route('video-tutorials')->with(['message' => 'Los datos del video han sido editados correctamente']);

        }  

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Video  $video

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $video = Video::find($id);
        @unlink(public_path('uploads')."/".$video->url_document);
        if($video->delete()){

            return redirect()->route('video-tutorials')->with(['message' => 'El video ha sido eliminado correctamente']);

        }

    }



    public function list(Request $request)

    {

        $id = $request['id'];

        $video = Video::find($id);

        return json_encode($video);

    }

}

