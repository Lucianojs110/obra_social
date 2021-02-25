<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Mensaje;
use App\Prestador;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Mail\Mailable;
class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user_id = Auth::user()->id;
		$mensajes = Mensaje::where('id_envia', '=', $user_id)->orderByDesc('fecha')->with('userenvia','userrecibe')->get();
		$prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();
        if(Auth::user()->role == "Administrador"){
            $users = User::where('id', '!=', Auth::user()->id)->get();
        }else{
            $users = User::where('role', '=', "Administrador")->get();
        }
      
		return view('mensajes', [
			'mensajes' => $mensajes,
			'prestador_menu' => $prestador_menu,
            'users' => $users,
            'titulo' => 'Enviados'
		]);
    }
    //PARA MENSAJES RECIBIDOS
    public function index2()
    {
        $user_id = Auth::user()->id;
        $mensajes = Mensaje::where('id_recibe', '=', $user_id)->orWhere('id_recibe', '=', 1)->where('id_envia', '=', 1)->orderByDesc('fecha')->with('userenvia','userrecibe')->get();
        $prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();
        if(Auth::user()->role == "Administrador"){
            $users = User::where('id', '!=', Auth::user()->id)->get();
        }else{
            $users = User::where('id', '=', 1)->get();
        }
      
        return view('mensajes', [
            'mensajes' => $mensajes,
            'prestador_menu' => $prestador_menu,
            'users' => $users,
            'titulo' => 'Recibidos'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { date_default_timezone_set('America/Argentina/Buenos_Aires');
        $validate = $this->validate($request,[
            'titulo' => ['required', 'max:50'],
            'mensaje' => ['required', 'max:255'],
            'file' => 'mimes:pdf,jpeg,gif,png,doc,docx|max:2048'
        ]);


        $enviaratodos = $request->input('enviaratodos');
        $id_recibe = $request->input('id_recibe');
        $id_envia = $request->input('id_envia');
        $titulo = $request->input('titulo');
        $titulo = htmlentities($titulo);
        $mensaje = $request->input('mensaje');
        $redir =$request->input('redir');
        $fileName="";
        if($enviaratodos){
            $msg = new Mensaje;
         
            $msg->id_recibe = 1;
            $msg->id_envia = 1;
            $msg->titulo = $titulo;
            $msg->mensaje = $mensaje;
            $msg->fecha = date('Y-m-d H:i:s');
            if($request->hasFile('file')){
                if($request->file->extension()){
                    $fileName = time().'.'.$request->file->extension();  
                    $request->file->move(public_path('uploads')."/mensaje/", $fileName);
                    $msg->archivo=$fileName;
               }
            }
            $users = User::where('id','!=', 1)->get();
          	foreach ($users as $key => $user) {
            		$this->email($user->email,$titulo,$mensaje,$fileName);
            }
            $msg->save();
            return redirect()->route('mensajes')->with(['message' => 'El mensaje se ha guardado']);
        }else{
            if($request->hasFile('file')){
                if($request->file->extension()){
                    $fileName = time().'.'.$request->file->extension();  
                    $request->file->move(public_path('uploads')."/mensaje/", $fileName);
               }
            }
            if(is_array($id_recibe)){
                $cantidad = count($id_recibe);
                for ($i=0; $i < $cantidad  ; $i++) { 

                    $msg = new Mensaje;
                    $msg->id_recibe = $id_recibe[$i];
                    $msg->id_envia = $id_envia;
                    $msg->titulo = $titulo;
                    $msg->mensaje = $mensaje;
                    $msg->fecha = date('Y-m-d H:i:s');
                    $msg->archivo=$fileName;
                    $msg->save();
                    $user = User::where('id', $id_recibe[$i])->first();
                    //enviar mail
                    if($user->email){
                        $data = array('name'=>$user->name." ".$user->surname);
                           // $to = 'johny@example.com, sally@example.com'; // note the comma
                                $this->email($user->email,$titulo,$mensaje,$fileName);
            // Subject
                       
                          /*Mail::send(['text'=>'probando'], $data, function($message) {
                             $message->to($user->email, 'Tutorials Point')->subject
                                ('Laravel Basic Testing Mail');
                             $message->from('sistema@dorita365.com','Sistema');
                          });*/
                        

                    }
                    
                    # code...
                }
            }
            if($redir){
                return redirect()->route('admin-users')->with(['message' => 'El mensaje se enviado']);
            }else{
                return redirect()->route('mensajes')->with(['message' => 'El mensaje se ha enviado']);
            }
        }



        //Guardo en BBDD

       






    }
    public function email($to,$titulo,$mensaje,$archivo){
         $subject = 'Nuevo mensaje del sistema';
         $url_sistema = url('/mensajes');
         if($archivo){
         	$txt_archivo =url('/public/uploads/mensaje')."/".$archivo;
         	$txt_archivo ='<a href="'.$txt_archivo.'" target="_blank">Ver archivo<a>';
         }else{
         	$txt_archivo ="";
         }
                // Message
                        $message = "
                    <html>
                    <head>
                      <title>$titulo</title>
                    </head>
                    <body>
                      <p>Nuevo mensaje del sistema</p>
                      <p><strong>Título:</strong> $titulo</p>
                      <p><strong>Mensaje:</strong> $mensaje</p>
                      <p>$txt_archivo</p>
                      <p><a href='$url_sistema' target='_blank'>Ver en el sistema</a></p>
                    </body>
                    </html>
                    ";


            // To send HTML mail, the Content-type header must be set
                            $headers[] = 'MIME-Version: 1.0';
                            $headers[] = 'Content-type: text/html; charset=utf-8';

                                 // Additional headers
                            //$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
                            $headers[] = 'From: Sistema <sistema@dorita365.com>';
                            //$headers[] = 'Cc: birthdayarchive@example.com';
                            //$headers[] = 'Bcc: birthdaycheck@example.com';

            // Mail it
                         return   mail($to, $subject, $message, implode("\r\n", $headers));
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
			'mensaje' => ['required']
		]);

		$mensaje = new Mensaje;
		$mensaje->fecha = $request->mensaje;
		$mensaje->save();
		return redirect()->route('mensajes')->with(['message' => 'El mensaje ha sido guardado correctamente']);			
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function show(mensaje $mensaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function edit(mensaje $mensaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		// Creo obra social
		$validate = $this->validate($request,[
			'mensaje' => ['required']
		]);

		$mensaje = mensaje::findOrFail($request->id);
		$mensaje->fecha = $request->mensaje;
		$mensaje->save();
		return redirect()->route('mensajes')->with(['message' => 'El mensaje ha sido editado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mensaje  $mensaje
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$redir)
    {
		$mensaje = mensaje::findOrFail($id);
        @unlink(public_path('uploads')."/mensaje/". $mensaje->archivo);
		$mensaje->delete();
		if($redir){
			return redirect()->route('mensajes-recibidos')->with(['message' => 'El mensaje ha sido eliminado correctamente']);
		}else{
			return redirect()->route('mensajes')->with(['message' => 'El mensaje ha sido eliminado correctamente']);
		}
    }
}
