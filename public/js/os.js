// Data tables
var host = "https://www.dorita365.com/";
$(document).ready(function(){
    
    $.noConflict();
    var table = $('.tablaBeneficiario').DataTable({
    responsive: true,
      "deferRender": true,
      "retrieve": true,
      "order": [1, 'asc'],
      "pageLength": 50,
      "processing": true,
         "language": {

          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }

      }
   });

    var tableusuarios = $('.tablas').DataTable({
    responsive: true,
      "deferRender": true,
      "retrieve": true,
      "order": [1, 'asc'],
      "pageLength": 50,
      "processing": true,
         "language": {

          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }

      }
   });
   
  var tablaFeriados =   $('.tablaFeriados').DataTable({
      "deferRender": true,
      "retrieve": true,
      "order": [1, 'desc'],
      "pageLength": 50,
      "processing": true,
         "language": {

          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }

      }
   });

   
	if($("#searchbox").val() != '' && $('#searchbox').val() != undefined){
		table.search($('#searchbox').val()).draw();
	}
   
    $("#searchbox").keyup(function() {
        table.search(this.value).draw();
    }); 
    
    $(document).on('change', '#searchbox', function(){
		table.search($('#searchbox').val()).draw();
	});
	
	$(document).on('click', '#btnClearSearchbox', function(){
		$('#searchbox').val('').trigger('change');
	});
	
	// Feriados
	var feriado = $('.feriadoInput');
	$.each(feriado, function (indexInArray, valueOfElement) { 
		$(valueOfElement).daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			startDate: moment().format('DD/MM/YYYY'),
			locale: {
				format: 'DD/MM/YYYY'
			}
		});
	});	
});

// Editar Feriado
$(document).on('click', '.btnEditarFeriado', function(){
	var id = $(this).attr('data-id');
	$('#feriado_id').val(id);
});

// Eliminar Feriado
$(document).on("click", ".btnEliminarFeriado", function(){
  var id = $(this).attr("data-id");

  swal({
    title: '¿Está seguro de borrar el feriado?',
    text: "¡Una vez eliminado, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar feriado!'
  }).then(function(result){

    if(result.value){

      window.location = host+"feriado/delete/"+id;

    }

  });

});

function hideAlerts(){
	setTimeout(() => {
		$('.alert').hide();
	}, 5000);
}

$('.sidebar-toggle').on('click',function(){
           var cls =  $('body').hasClass('sidebar-collapse');
           if(cls == true){
                $('body').removeClass('sidebar-collapse');
           } else {
                $('body').addClass('sidebar-collapse');
           }
});


// Info de OS
$(document).on('click', '.btnEditarOs', function(){
	var id = $(this).attr("idos");

$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


$.ajax({
	url: host+"obrasocial/list",
	data: {id:id},
	dataType: "json",
	type: "POST",
	success: function(respuesta){
		$("#id").val(respuesta["id"]);
		$("#editarNombre").val(respuesta["nombre"]);
		$("#editarCuit").val(respuesta["cuit"]);
		$("#editarTelefono").val(respuesta["telefono"]);
		$("#editarCiudad").val(respuesta["ciudad"]);
		$("#editarDireccion").val(respuesta["direccion"]);
		$("#editarEmail").val(respuesta["email"]);
		$("#editarCondicionIva").val(respuesta["condicion_iva"]);
		$("#editarValorSesion").val(respuesta["valor_sesion"]);
		$("#editarValorKm").val(respuesta["valor_km"]);
		$("#editarValorModulo").val(respuesta["valor_modulo"]);
		$("#editarnomenclador").val(respuesta["nomenclador"]);
		}
	});
});

// Info de user
$(document).on('click', '.btnEditarUsuario', function(){
  var id = $(this).attr("iduser");
$.ajaxSetup({
  headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


$.ajax({
  url: host+"user/list",
  data: {id:id},
  dataType: "json",
  type: "POST",
  success: function(respuesta){
    $("#iduser").val(respuesta["id"]);
    $("#direccion").val(respuesta["direccion"]);
    $("#provincia").val(respuesta["id_provincia"]);
    $("#localidad").val(respuesta["localidad"]);
    $("#telefono").val(respuesta["telefono"]);
    $("#cuit").val(respuesta["cuit"]);
    $("#condicionIva").val(respuesta["condicion_iva"]);
    $("#condicionIibb").val(respuesta["condicion_iibb"]);
    $("#iibb").val(respuesta["iibb"]);
    $("#entidadBancaria").val(respuesta["entidad_bancaria"]);
    $("#cbu").val(respuesta["cbu"]);
    $("#ordenCheque").val(respuesta["orden_cheque"]);
    $("#lugarPago").val(respuesta["lugar_pago"]);
    $("#empSeguros").val(respuesta["emp_seguros"]);
    $("#polSeguros").val(respuesta["poliza"]);
    $("#correo").val(respuesta["email"]);
    $("#name").html(respuesta["name"]+' '+respuesta["surname"]);
    
    }
  });
});

// Info de user
$(document).on('click', '.btnEnviarMensajeAdmin', function(){
  var id = $(this).attr("iduser");
$.ajaxSetup({
  headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


$.ajax({
  url: host+"user/list",
  data: {id:id},
  dataType: "json",
  type: "POST",
  success: function(respuesta){
    $("#id_recibe").val(respuesta["id"]);
    
    }
  });
});

// Editar datos Prestador
$(document).on('click', '.btnEditarPrestacion', function(){

var id = $(this).attr("idprest");

$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$.ajax({
	url: host+"prestador/list",
	data: {id:id},
	dataType: "json",
	type: "POST",
	success: function(respuesta){
		$("#editarNumeroPrestador").val(respuesta["numero_prestador"]);
		$("#editar_utiliza_valor_profesion").val(respuesta["valor_default"]);
		$("#id").val(respuesta["id"]);
		$("#editar_mover_dias").val(respuesta["mover_dias"]);
        $("#editar_quitar_feriado").val(respuesta["quitar_feriado"]);
        $("#editar_tope").val(respuesta["tope"]);
		}
	});
});

// Eliminar datos de prestador
$(document).on("click", ".btnEliminarDatosPrestador", function(){
  var id = $(this).attr("idPrest");

  swal({
    title: '¿Está seguro de borrar los datos de prestador?',
    text: "¡Una vez eliminados, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar prestador!'
  }).then(function(result){

    if(result.value){

      window.location = host+"prestador/destroy/"+id;

    }

  });

});

// Eliminar datos de contrato
$(document).on("click", ".btnEliminarcontrato", function(){
  var id = $(this).attr("idPrest");

  swal({
    title: '¿Está seguro de borrar los datos de contrato?',
    text: "¡Una vez eliminados, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar contrato!'
  }).then(function(result){

    if(result.value){

      window.location = host+"contrato/delete/1";

    }

  });

});
// Eliminar usuarios
$(document).on("click", ".btnEliminarUsuario", function(){
  var id = $(this).attr("iduser");

  swal({
    title: '¿Está seguro de borrar el usuario?',
    text: "¡Una vez eliminados, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar usuario!'
  }).then(function(result){

    if(result.value){

      window.location = host+"user/delete/"+id;

    }

  });

});
// Bloquear usuarios
$(document).on("click", ".btnBloquearUsuario", function(){
  var id = $(this).attr("iduser");
  var banned = $(this).attr("banned");
  if(banned==0){
    var txt = "bloquear";
  }else{
    var txt = "desbloquear"
  }
  swal({
    title: '¿Está seguro de '+txt+' el usuario?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, '+txt+' usuario!'
  }).then(function(result){

    if(result.value){
      if(banned ==0){
        window.location = host+"user/bloquear/"+id;
      }else{
        window.location = host+"user/desbloquear/"+id;
      }
      

    }

  });

});
//Editar Beneficiario
$(document).on('click', '.btnEditarBeneficiario', function(){

var id = $(this).attr("idbenef");

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$.ajax({
	url: host+"beneficiario/list",
	data: {id:id},
	dataType: "json",
	type: "POST",
	success: function(respuesta){
		$("#id").val(respuesta['beneficiario'][0]["id"]);
		$("#editarNombre").val(respuesta['beneficiario'][0]["nombre"]);
		$("#editarApellido").val(respuesta['beneficiario'][0]["apellido"]);
		$("#editarCorreo").val(respuesta['beneficiario'][0]["email"]);
		$("#editarTelefono").val(respuesta['beneficiario'][0]["telefono"]);
		$("#editarDireccion").val(respuesta['beneficiario'][0]["direccion"]);
		$("#editarLocalidad").val(respuesta['beneficiario'][0]["localidad"]);
		$("#editarDireccionPrestacion").val(respuesta['beneficiario'][0]["direccion_prestacion"]);
		$("#editarLocalidadPrestacion").val(respuesta['beneficiario'][0]["localidad_prestacion"]);
		$("#editarCuit").val(respuesta['beneficiario'][0]["cuit"]);
		$("#editarDni").val(respuesta['beneficiario'][0]["dni"]);
		$("#editardiscapacidad").val(respuesta['beneficiario'][0]["discapacidad"]);
		$("#editarKmIda").val(respuesta['beneficiario'][0]["km_ida"]);
		$("#editarKmVuelta").val(respuesta['beneficiario'][0]["km_vuelta"]);
		$("#editarViajesIda").val(respuesta['beneficiario'][0]["viajes_ida"]);
		$("#editarViajesVuelta").val(respuesta['beneficiario'][0]["viajes_vuelta"]);
		$("#editarTurno").val(respuesta['beneficiario'][0]["turno"]);
		$("#editarDependencia").val(respuesta['beneficiario'][0]["dependencia"]);
		$("#editarNotas").val(respuesta['beneficiario'][0]["notas"]);
		$("#editar_numero_afiliado").val(respuesta['beneficiario'][0]['numero_afiliado']);
		$("#editar_codigo_seguridad").val(respuesta['beneficiario'][0]['codigo_seguridad']);
		$("#editar_cantidad_solicitada").val(respuesta['beneficiario'][0]['cantidad_solicitada']);
	    $("#codigo_traditum").val(respuesta['traditum'][0]['codigo']);
		$("#tituloEditarBeneficiario").empty().html('Editar Beneficiario - ' + respuesta['beneficiario'][0]["nombre"] + ' - ' + respuesta['prestacion'] +' - ' +respuesta['prestacion_completa'][0]['obrasocial'][0]['nombre']);
		$("#editarprovincia").val(respuesta['beneficiario'][0]['id_provincia']);
    $("#editarid_provincia_prestacion").val(respuesta['beneficiario'][0]['id_provincia_prestacion']);
    $("#editarDiasMensuales").val(respuesta['beneficiario'][0]['dias_mensuales']);
    $("#editarconsentimiento").val(respuesta['beneficiario'][0]['consentimiento']);
    
	}
	});
});
function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}
//Editar inactivo
$(document).on('click', '.btnEditarInactivo', function(){
  var id = $(this).attr("data-id");
  var dataos_id = $(this).attr("data-os_id");
  var fecha = $(this).attr("data-fecha");
  var fechafin = $(this).attr("data-fechafin");

  $("#id").val(id );
  $("#id_os").val(dataos_id);
  $("#fecha").val(fecha);
  $("#fecha_fin").val(fechafin);
  
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
});

//Editar Beneficiario
$(document).on('click', '.btnEditarBeneficiarioOsecac', function(){

var id = $(this).attr("idbenef");

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$.ajax({
	url: host+"beneficiario/list",
	data: {id:id},
	dataType: "json",
	type: "POST",
	success: function(respuesta){
		$("#idOsecac").val(respuesta['beneficiario'][0]["id"]);
		$("#editarNombreOsecac").val(respuesta['beneficiario'][0]["nombre"]);
		$("#editarApellidoOsecac").val(respuesta['beneficiario'][0]["apellido"]);
		$("#editarCorreoOsecac").val(respuesta['beneficiario'][0]["email"]);
		$("#editarTelefonoOsecac").val(respuesta['beneficiario'][0]["telefono"]);
		$("#editarDireccionOsecac").val(respuesta['beneficiario'][0]["direccion"]);
		$("#editarLocalidadOsecac").val(respuesta['beneficiario'][0]["localidad"]);
		$("#editarDireccionPrestacionOsecac").val(respuesta['beneficiario'][0]["direccion_prestacion"]);
		$("#editarLocalidadPrestacionOsecac").val(respuesta['beneficiario'][0]["localidad_prestacion"]);
		$("#editarCuitOsecac").val(respuesta['beneficiario'][0]["cuit"]);
		$("#editarDniOsecac").val(respuesta['beneficiario'][0]["dni"]);
		$("#editardiscapacidadOsecac").val(respuesta['beneficiario'][0]["discapacidad"]);
		$("#editarKmIdaOsecac").val(respuesta['beneficiario'][0]["km_ida"]);
		$("#editarKmVueltaOsecac").val(respuesta['beneficiario'][0]["km_vuelta"]);
		$("#editarViajesIdaOsecac").val(respuesta['beneficiario'][0]["viajes_ida"]);
		$("#editarViajesVueltaOsecac").val(respuesta['beneficiario'][0]["viajes_vuelta"]);
		$("#editarTurnoOsecac").val(respuesta['beneficiario'][0]["turno"]);
		$("#editarDependenciaOsecac").val(respuesta['beneficiario'][0]["dependencia"]);
		$("#editarNotasOsecac").val(respuesta['beneficiario'][0]["notas"]);
		$("#editarTransporte_aOsecac").val(respuesta['beneficiario'][0]["transporte_a"]);
		$("#editar_numero_afiliado_osecac").val(respuesta['beneficiario'][0]['numero_afiliado']);
		$("#editar_codigo_seguridad_osecac").val(respuesta['beneficiario'][0]['codigo_seguridad']);
		$("#editar_cantidad_solicitada_osecac").val(respuesta['beneficiario'][0]['cantidad_solicitada']);
		$('#editarDiasMensuales').val(respuesta['beneficiario'][0]['dias_mensuales']);
		$("#tituloEditarBeneficiarioOsecac").empty().html('Editar Beneficiario - ' + respuesta['beneficiario'][0]["nombre"] + ' - ' + respuesta['prestacion'] +' - ' +respuesta['prestacion_completa'][0]['obrasocial'][0]['nombre']);
		$("#editarprovinciaOsecac").val(respuesta['beneficiario'][0]['id_provincia']);
    $("#editarid_provincia_prestacionOsecac").val(respuesta['beneficiario'][0]['id_provincia_prestacion']);
    $("#editarconsentimientoOsecac").val(respuesta['beneficiario'][0]['consentimiento']);
		}
	});
});

// Eliminar beneficiario
$(document).on("click", ".btnEliminarBeneficiario", function(){

  var idBenef = $(this).attr("idBenef");
  var idOs = $(this).attr("idOs");

  swal({
    title: '¿Está seguro de borrar el beneficiario?',
    text: "¡Una vez eliminado, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar beneficiario!'
  }).then(function(result){

    if(result.value){

      window.location = host+"beneficiario/delete/"+idOs+"/"+idBenef+"";

    }

  })

})
// Eliminar inactivo
$(document).on("click", ".btnEliminarInactivo", function(){

  var id = $(this).attr("idBenef");
  var idOs = $(this).attr("idOs");

  swal({
    title: '¿Está seguro de borrar?',
    text: "¡Una vez eliminado, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar!'
  }).then(function(result){

    if(result.value){

      window.location = host+"inactivo/delete/"+idOs+"/"+id+"";

    }

  })

})
// Eliminar mensaje
$(document).on("click", ".btnEliminarMensaje", function(){

  var id = $(this).attr("data-id");
   var redir = $(this).attr("redir");

  swal({
    title: '¿Está seguro de borrar el mensaje?',
    text: "¡Una vez eliminado, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar mensaje!'
  }).then(function(result){

    if(result.value){

      window.location = host+"mensajes/delete/"+id+"/"+redir;

    }

  })

})


// Eliminar beneficiario
$(document).on("click", ".btnEliminarBeneficiarioInactivo", function(){

  var idBenef = $(this).attr("idBenef");
  var idOs = $(this).attr("idOs");

  swal({
    title: '¿Está seguro de borrar el beneficiario?',
    text: "¡Una vez eliminado, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar beneficiario!'
  }).then(function(result){

    if(result.value){

      window.location = host+"beneficiario-inactivo/delete/"+idOs+"/"+idBenef+"";

    }

  });

});

// Activar o desactivar beneficiario
$(document).on('change', '.btnEstadoBeneficiario', function(){
  var idBenef = $(this).attr('idBenef');
  var idOs = $(this).attr('idOs');

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  if(this.checked){
    var status = 1;
    window.location = host+"beneficiario/status/"+idBenef+"/"+idOs+'/'+status
    
  }else{
    var status = 0;
    window.location = host+"beneficiario/status/"+idBenef+"/"+idOs+'/'+status
  }

});

// Activar o desactivar beneficiario
$(document).on('change', '.btnEstadoBeneficiarioInactivo', function(){
  var idBenef = $(this).attr('idBenef');
  var idOs = $(this).attr('idOs');

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var status = 1;
    window.location = host+"beneficiario-inactivo/status/"+idBenef+"/"+idOs+'/'+status
});

// Traigo prestaciones segun OS
$(document).on('change', '#obraSocial', function(){
	var idOs = $("#obraSocial").val();
	$("#role_profesion").empty();
	$("#role_profesion").append('<option value="">Seleccionar...</option>');
	
	$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
		});

		$.ajax({
			url: host+"prestacion/show/"+idOs+"",
			// data: {id:id},
			dataType: "json",
			success: function(respuesta){
				$.each(respuesta, function(key, val){
					$("#role_profesion").append('<option value='+val.id+'>'+val.nombre+'</option>');
				});
			}
		});
	});

// Agrego campo de valor personalizado
$(document).on('change', '#utiliza_valor_profesion', function(){
	if($("#utiliza_valor_profesion").val() == 'F'){
		$("#valor_profesion_personalizado").empty();
		$("#valor_profesion_personalizado").append('<label for="valor_profesion">Valor</label><input type="text" name="valor_profesion" class="form-control" placeholder="otro valor">');
	}else{
		$("#valor_profesion_personalizado").empty();
	}
});

// enviar a todos
$(document).on('change', '#enviaratodos', function(){
	if($("#enviaratodos").val() == '1'){
		$("#listausuarios").hide();
	}else{
		$("#listausuarios").show();
	}
});

// Agrego campo de valor personalizado en edicion
$(document).on('change', '#editar_utiliza_valor_profesion', function(){
  if($("#editar_utiliza_valor_profesion").val() == 'F'){
    $("#editar_valor_profesion_personalizado").empty();
    $("#editar_valor_profesion_personalizado").append('<label for="valor_profesion">Valor</label><input type="text" name="valor_profesion" class="form-control" placeholder="otro valor">');
  }else{
    $("#editar_valor_profesion_personalizado").empty();
  }
});


// Editar prestacion
$(document).on('click', '#btnEditarPrestacion', function(){
var idPrest = $(this).attr("idPrest");

	$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});

		$.ajax({
			url: host+"prestacionind/show/"+idPrest+"",
			// data: {id:id},
			dataType: "json",
			success: function(respuesta){
				$("#editar_obra_social").val(respuesta[0]['os_id']);
				$("#editar_codigo_modulo").val(respuesta[0]['codigo_modulo']);
				$("#editar_prestacion").val(respuesta[0]['nombre']);
				$("#editar_valor_prestacion").val(respuesta[0]['valor_modulo']);
				$("#editar_planilla").val(respuesta[0]['planilla']);
				$("#id").val(respuesta[0]['id']);
			}
		});
	});

// Eliminar prestacion
$(document).on("click", "#btnEliminarPrestacion", function(){

  var idPrest = $(this).attr("idPrest");

  swal({
    title: '¿Está seguro de borrar la prestación?',
    text: "¡Una vez eliminada, la acción no se podrá deshacer!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar prestación!'
  }).then(function(result){

    if(result.value){

      window.location = host+"prestacion/delete/"+idPrest;

    }

  })

});

/*Data mask*/
$(document).ready(function($){
    //Datemask hh:mm
    $('#datemask').inputmask('hh:mm', { 'placeholder': 'hh:mm am/pm' });
    //Datemask2 hh:mm
    $('#datemask2').inputmask('hh:mm', { 'placeholder': 'hh:mm am/pm' });
    //Money Euro
    $('[data-mask]').inputmask();
});

// Clonar beneficiario

$(document).on('click', '.btnClonarBeneficiario', function(){
    var id = $(this).attr("idbenef");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: host+"beneficiario/list",
        data: {id:id},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
        	$("#nombre_clon").empty();
            $("#correo_clon").empty();
            $("#telefono_clon").empty();
            $("#direccion_clon").empty();
            $("#localidad_clon").empty();
            $("#direccionPrestacion_clon").empty();
            $("#localidadPrestacion_clon").empty();
            $("#cuit_clon").empty();
            $("#dni_clon").empty();
            $("#kmIda_clon").empty();
            $("#kmVuelta_clon").empty();
            $("#viajesIda_clon").empty();
            $("#viajesVuelta_clon").empty();
            $("#turno_clon").empty();
            $("#dependencia_clon").empty();
            $("#notas_clon").empty();
            $("#numero_afiliado_clon").empty();
            $("#codigo_seguridad_clon").empty();
            $("#cantidad_solicitada_clon").empty();

            $("#nombre_clon").val(respuesta['beneficiario'][0]["nombre"]);
            $("#correo_clon").val(respuesta['beneficiario'][0]["email"]);
            $("#telefono_clon").val(respuesta['beneficiario'][0]["telefono"]);
            $("#direccion_clon").val(respuesta['beneficiario'][0]["direccion"]);
            $("#localidad_clon").val(respuesta['beneficiario'][0]["localidad"]);
            $("#prestacion_clon").val(respuesta['beneficiario'][0]["prestador"]["id"]);
            $("#direccionPrestacion_clon").val(respuesta['beneficiario'][0]["direccion_prestacion"]);
            $("#localidadPrestacion_clon").val(respuesta['beneficiario'][0]["localidad_prestacion"]);
            $("#cuit_clon").val(respuesta['beneficiario'][0]["cuit"]);
            $("#dni_clon").val(respuesta['beneficiario'][0]["dni"]);
            $("#KmIda_clon").val(respuesta['beneficiario'][0]["km_ida"]);
            $("#KmVuelta_clon").val(respuesta['beneficiario'][0]["km_vuelta"]);
            $("#ViajesIda_clon").val(respuesta['beneficiario'][0]["viajes_ida"]);
            $("#ViajesVuelta_clon").val(respuesta['beneficiario'][0]["viajes_vuelta"]);
            $("#turno_clon").val(respuesta['beneficiario'][0]["turno"]);
            $("#dependencia_clon").val(respuesta['beneficiario'][0]["dependencia"]);
            $("#notas_clon").val(respuesta['beneficiario'][0]["notas"]);
            $("#numero_afiliado_clon").val(respuesta['beneficiario'][0]['numero_afiliado']);
            $("#codigo_seguridad_clon").val(respuesta['beneficiario'][0]['codigo_seguridad']);
            $("#cantidad_solicitada_clon").val(respuesta['beneficiario'][0]['cantidad_solicitada']);
            $("#discapacidad_clon").val(respuesta['beneficiario'][0]['discapacidad']);
            $("#provincia_clon").val(respuesta['beneficiario'][0]['id_provincia']);
            $("#id_provincia_prestacion_clon").val(respuesta['beneficiario'][0]['id_provincia_prestacion']);
            

        }
    });
});

// Al presionar el boton de horarios traigo los resultados
$(document).on('click', '.btnHorarioBeneficiario', function(){
	$('.alertBenef').hide();
	var id = $(this).attr("idBenef");
	$("#horarioBenef").empty();
	$("#tope").empty();
	$("#tope").attr('idBenef', id);
	$(".id_beneficiario").val(id);
	$(".btnInasistencias").attr('idBenef', id);
	$('.horarioSuccess').hide();
	$('.alertBenef').hide();
	var fecha_tope = $(this).attr('cuenta-tope');
	var fecha_original = $(this).attr('cuenta-original');
	var fecha_agregados = $(this).attr('cuenta-agregados');
	var suma = (Number(fecha_tope)+Number(fecha_agregados));
// 	console.log('suma', suma); 
// 	if(suma < fecha_original || suma == 0){
// 		$('.btnHorarioIndividual').show();
// 	}else{
// 		$('.btnHorarioIndividual').hide();
// 	}

	 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$("#beneficiario_id").val(id);
	$('#dia').select2({
		closeOnSelect: false
	});

    $.ajax({
        url: host+"sesion/horarios",
        data: {id:id},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
            console.log(respuesta);
        	$("#tope").val(respuesta['beneficiario']['tope']);
            if(respuesta['beneficiario']['tope'] == null){
                $('#optionsRadios1').prop('checked', true);
            }else{
                $('#optionsRadios2').prop('checked', true);
            }
        	for (var i = 0; i < respuesta['sesiones'].length; i++) {
        		switch( Number(respuesta['sesiones'][i]["dia"])){
        			case 1:
        				dia = 'Lunes';
        				break;
        			case 2:
        				dia = 'Martes';
        				break;
        			case 3: 
        				dia = 'Miercoles';
        				break;
        			case 4:
        				dia = 'Jueves';
        				break;
        			case 5:
        				dia = 'Viernes';
        				break;
        			case 6:
        				dia = 'Sabado';
        				break;
        			case 7:
        				dia = 'Domingo';
        				break;
        		}
        		
        		console.log('dia', dia);

        		$("#horarioBenef").append('<tr><td>'+dia+'</td><td>'+respuesta['sesiones'][i]["hora"]+ ' - ' + respuesta['fin_sesion'][i] +'</td><td>'+respuesta['sesiones'][i]["tiempo"]+' minutos</td><td><button class="btn btn-danger btnEliminarSesion" idSesion="'+respuesta['sesiones'][i]["id"]+'"><i class="fa fa-trash"></i></button></td></tr>')
        	}
        }
    });
    
        var obrasocial = $('.obra_social').val(); 

        $.ajax({
        url: host+"beneficiario/list",
        data: {id:id},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
               $('.horarioBeneficiario').empty();
                $('.horarioBeneficiario').append('Horario Beneficiario - '+respuesta['beneficiario'][0]['nombre']+ ' - '+respuesta['prestacion']+' - '+obrasocial);
                $('.inasistenciaBeneficiario').empty();
                $('.inasistenciaBeneficiario').append('Fechas de Beneficiario - '+respuesta['beneficiario'][0]['nombre']+ ' - '+respuesta['prestacion']+' - '+obrasocial);
				$('#benefNombre').val(respuesta['beneficiario'][0]['nombre']);
            }
        });
});

// Guardo Horario
$(document).on('click', '#guardarHorario', function(){
	
    $('.alertBenef').hide();
	// Obtengo valores
	var dia = $("#dia").val();
	var hora = $("#hora").val();
	var tiempo = $(".selectTiempo");
	$.each(tiempo, function(ind, el){
		if(el.value != ''){
			tiempo = el;
		}
	});
	var beneficiario_id = $("#beneficiario_id").val();
	var obrasocial_id = $("#obrasocial_id").val();
  	var tope = $("#tope").val();

	$("#horarioBenef").empty();

    $.ajax({
        url: host+"sesion/create",
        data: {dia:dia, hora:hora, tiempo:tiempo.value, beneficiario_id:beneficiario_id, obrasocial_id:obrasocial_id, tope:tope},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
            console.log(respuesta);
        	if(respuesta['error']){
                $('#errorBenef').html(respuesta['error']);
                $('.alertBenef').show();
            }
        	for (var i = 0; i < respuesta['sesiones'].length; i++) {
        		switch( Number(respuesta['sesiones'][i]["dia"])){
        			case 1:
        				dia = 'Lunes';
        				break;
        			case 2:
        				dia = 'Martes';
        				break;
        			case 3: 
        				dia = 'Miercoles';
        				break;
        			case 4:
        				dia = 'Jueves';
        				break;
        			case 5:
        				dia = 'Viernes';
        				break;
        			case 6:
        				dia = 'Sabado';
        				break;
        			case 7:
        				dia = 'Domingo';
        				break;
        		}

                $("#horarioBenef").append('<tr><td>'+dia+'</td><td>'+respuesta['sesiones'][i]["hora"]+ ' - ' + respuesta['fin_sesion'][i] +'</td><td>'+respuesta['sesiones'][i]["tiempo"]+' minutos</td><td><button class="btn btn-danger btnEliminarSesion" idSesion="'+respuesta['sesiones'][i]["id"]+'"><i class="fa fa-trash"></i></button></td></tr>');  
                $("#dia").val('');
        		$("#hora").val('');
        		$("#tiempo").val('');
        	}
        }
    });
    
    hideAlerts();
});

//Eliminar sesion
$(document).on('click', '.btnEliminarSesion', function(){
	var id = $(this).attr("idSesion");
	var beneficiario_id = $("#beneficiario_id").val();

	$("#horarioBenef").empty();

	    $.ajax({
        url: host+"sesion/destroy",
        data: {id:id, beneficiario_id:beneficiario_id},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
        	for (var i = 0; i < respuesta.length; i++) {
        		switch( respuesta[i]["dia"]){
        			case 1:
        				dia = 'Lunes';
        				break;
        			case 2:
        				dia = 'Martes';
        				break;
        			case 3: 
        				dia = 'Miercoles';
        				break;
        			case 4:
        				dia = 'Jueves';
        				break;
        			case 5:
        				dia = 'Viernes';
        				break;
        			case 6:
        				dia = 'Sabado';
        				break;
        			case 7:
        				dia = 'Domingo';
        				break;
        		}

        		$("#horarioBenef").append('<tr><td>'+dia+'</td><td>'+respuesta[i]["hora"]+'</td><td>'+respuesta[i]["tiempo"]+' minutos</td><td><button class="btn btn-danger btnEliminarSesion" idSesion="'+respuesta[i]["id"]+'"><i class="fa fa-trash"></i></button></td></tr>');
        	}
        }
    });
});

// Editar video
$(document).on('click', '.btnEditarVideo', function(){
    var id = $(this).attr('data-id');
    $('#video_id').empty();
    $('#video_description').empty();
    $('#video_url_video').empty();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
        url: host+"video/list",
        data: {id:id},
        dataType: "json",
        type: "POST",
        success: function(respuesta){
            $('#video_id').val(respuesta['id']);
            $('#video_description').val(respuesta['description']);
            $('#video_url_video').val(respuesta['url_video']);
            if(respuesta['url_document']){
            	$('#eliminarvideo').html('<input type="checkbox" name="eliminarvideo" value="1"> Eliminar video');
        	}
        }
    });
});

// Eliminar video
$(document).on('click', '.btnEliminarVideo', function(){
    var id = $(this).attr('data-id');

      swal({
        title: '¿Está seguro de borrar el video?',
        text: "¡Una vez eliminado, la acción no se podrá deshacer!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, borrar video!'
      }).then(function(result){

        if(result.value){

          window.location = host+"video/delete/"+id;

        }

      })

})

$(document).on('click', '.selectMesNuevo', function(){
   var idOs = $(this).attr('idOs');
   var idPrest = $(this).attr('idPrest');
   var anio = $(this).attr('anio');
   var mes = $(this).attr('mes');

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url: host+"user/month",
    data: {mes:mes, idOs:idOs, idPrest:idPrest, anio:anio},
    type: "POST",
    success: function(respuesta){
      if(respuesta == 1){
       window.location = host+"beneficiarios/"+idPrest+"/"+idOs+"/"+mes+"/"+anio;
      }
    },
    error: function(respuesta){
      console.log('error', respuesta);
    }
  });
});

// Mes y año
$(document).on('change', '.selectMes', function(){
   var idOs = $(this).attr('idOs');
   var idPrest = $(this).attr('idPrest');
   var anio = $('.selectAnio').val();
   var mes = $(this).val();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url: host+"user/month",
    data: {mes:mes, idOs:idOs, idPrest:idPrest, anio:anio},
    type: "POST",
    success: function(respuesta){
      if(respuesta == 1){
       window.location = host+"beneficiarios/"+idPrest+"/"+idOs+"/"+mes+"/"+anio;
      }
    },
    error: function(respuesta){
      console.log('error', respuesta);
    }
  });
});

$(document).on('change', '.selectAnio', function(){
   var idOs = $(this).attr('idOs');
   var idPrest = $(this).attr('idPrest');
   var mes = $('.selectMes').val();
   var anio = $(this).val();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url: host+"user/year",
    data: {mes:mes, idOs:idOs, idPrest:idPrest, anio:anio},
    type: "POST",
    success: function(respuesta){
      if(respuesta == 1){
       window.location = host+"beneficiarios/"+idPrest+"/"+idOs+"/"+mes+"/"+anio;
      }
    },
    error: function(respuesta){
      console.log('error', respuesta);
    }
  });
});

$(document).on('change', '.traditum', function(){
    var benef_id = $(this).attr('beneficiario-id');
    var tradit_id = $(this).attr('traditum-id');
    var val = $(this).val();
    console.log("val", val);

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: host+"beneficiario/traditum",
      data: {beneficiario:benef_id, traditum: tradit_id, valor:val},
      type: "POST",
      success: function(respuesta){
        console.log("respuesta", respuesta);      
      }
    });
});


// Inasistencias Beneficiario
$(document).on('click', '.btnInasistencias', function(){
	$('.appended-inasistencias').empty();
    var id = $(this).attr('idBenef');
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: host+"beneficiario/inasistenciasBeneficiario",
      data: {id:id},
      type: "POST",
      success: function(respuesta){
        if(respuesta.success){
          $(respuesta.inasistencias).each(function(i, v){
            console.log(v);
            $('.appended-inasistencias').append(`
                <div class="row">
                  <div class="col-lg-12" style="margin-top: 5px;">
                    <div class="col-lg-3">
                      `+v['rango_fechas']+`
                    </div>
                    <div class="col-lg-3">
                      `+v['tipo']+`
                    </div>
                    <div class="col-lg-3">
                      <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                </div>
            `);
          });
        }else{

        }   
      }
    });
});


$(document).on('click', '.btnInasistenciaIndividual', function(){
	$('.inasistenciaIndividual').show();
	$('.horarioIndividual').hide();
	$('.rangoInasistencia').hide();
	$('.rangoHorario').hide();
});

$(document).on('click', '.btnHorarioIndividual', function(){
	$('.horarioIndividual').show();
	$('.inasistenciaIndividual').hide();
	$('.rangoHorario').hide();
});

// $(document).on('click', '.btnAgregarHorario', function(){
//   $('#inputsAdicionales').append(`
//       <div class="row">
//         <div class="col-lg-5">
//           <label for="fechas[]">Fecha</label>
//           <input type="text" id="fechas[]" class="form-control input-sm fechasMask" name="fechas[]" placeholder="dd/mm/aaaa">
//         </div>
//         <div class="col-lg-1" style="padding-left: 0px; margin-top: 30px;">
//           <button class="btn btn-xs btn-success btnAgregarHorario" type="button"><i class="fa fa-plus"></i></button>
//         </div>
//   `);
//     $('.fechasMask').mask('00/00/0000');
// });

$(document).on('click', '.btnAgregarHorario', function(){
    var form = $('.formHorarios');
    $("<input />").attr('type', 'hidden').attr('name', 'agregarToForm').attr('value', 'Agregar').appendTo(form);
    
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: host+"beneficiario/inasistencias",
      data: form.serialize(),
      type: "POST",
      success: function(respuesta){
        if(respuesta.success){
          $('.horarioSuccess').show();
          $('#horarioSuccess').empty();
          $('#horarioSuccess').append(respuesta.message);
          $('.appended-inasistencias').empty();
          $(respuesta.inasistencias).each(function(i, v){
            $('.appended-inasistencias').append(`
              <div class="row">
                <div class="col-lg-12" style="margin-top: 5px;">
                  <div class="col-lg-3">
                    `+v['rango_fechas']+`
                  </div>
                  <div class="col-lg-3">
                    `+v['tipo']+`
                  </div>
                  <div class="col-lg-3">
                    <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
                  </div>
                </div>
              </div>
            `);
          });
        }else{
          $('.horarioFail').show();
          $('#horarioFail').empty();
          $('#horarioFail').append(respuesta.message);
        }   
      },
	  error:function(respuesta){
		  console.log(respuesta);
			$('.horarioFail').show();
			$('#horarioFail').empty();
			$('#horarioFail').append(respuesta.responseJSON['message']);
	  }
    });
    
    hideAlerts();
});

$(document).on('click', '.btnRemoverHorario', function(){
    var form = $('.formInasistencias');
    $("<input />").attr('type', 'hidden').attr('name', 'agregarToForm').attr('value', 'Sacar').appendTo(form);
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    console.log(form.serialize());
    $.ajax({
      url: host+"beneficiario/inasistencias",
      data: form.serialize(),
      type: "POST",
      success: function(respuesta){
        if(respuesta.success){
          $('.inasistenciaSuccess').show();
          $('#inasistenciaSuccess').empty();
          $('#inasistenciaSuccess').append(respuesta.message);
          $('.appended-inasistencias').empty();
          $(respuesta.inasistencias).each(function(i, v){
            $('.appended-inasistencias').append(`
              <div class="row">
                <div class="col-lg-12" style="margin-top: 5px;">
                  <div class="col-lg-3">
                    `+v['rango_fechas']+`
                  </div>
                  <div class="col-lg-3">
                    `+v['tipo']+`
                  </div>
                  <div class="col-lg-3">
                    <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
                  </div>
                </div>
              </div>
            `);
          });
        }else{
          $('.inasistenciaFail').show();
          $('#inasistenciaFail').empty();
          $('#inasistenciaFail').append(respuesta.message);
        }   
      }
    });
});

// $(document).on('click', '.btnRangoHorario', function(){
//   $('.rangoHorario').show();
//   $('.horarioIndividual').hide();
//   $('.rangoInasistencia').hide();
//   $('#daterange-btn').daterangepicker(
//       {
//         ranges   : {
//         },
//         startDate: moment(),
//         endDate  : moment()
//       },
//       function (start, end) {
//          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
//          var fechaInicial = start.format('DD/MM/YYYY');
//          var fechaFinal = end.format('DD/MM/YYYY');
//          var capturarRango = $("#daterange-btn span").html();

//          // Valores para rango de sesion
//          var idBeneficiario = $('.id_beneficiario').val();
//          var cantidad = $('.cantidad').val();
//          var fechas = fechaInicial+' - '+fechaFinal;
//          var tipo = 'Agregado';
//          var from = 'Calendar';
//         $.ajaxSetup({
//           headers: {
//               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//           }
//         });

//         $.ajax({
//             url: host+"beneficiario/inasistencias",
//             data: {id_beneficiario:idBeneficiario, cantidad:cantidad, fechas:fechas, agregarToForm:tipo},
//             type: "POST",
//             success: function(respuesta){
//               if(respuesta.success){
//                 $('.inasistenciaSuccess').show();
//                 $('#inasistenciaSuccess').empty();
//                 $('#inasistenciaSuccess').append(respuesta.message);
//                 $('.appended-inasistencias').empty();
//                 $(respuesta.inasistencias).each(function(i, v){
//                   $('.appended-inasistencias').append(`
//                     <div class="row">
//                       <div class="col-lg-12" style="margin-top: 5px;">
//                         <div class="col-lg-3">
//                           `+v['rango_fechas']+`
//                         </div>
//                         <div class="col-lg-3">
//                           `+v['tipo']+`
//                         </div>
//                         <div class="col-lg-3">
//                           <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
//                         </div>
//                       </div>
//                     </div>
//                   `);
//                 });
//               }else{
//                 $('.inasistenciaFail').show();
//                 $('#inasistenciaFail').append(respuesta.message);
//               }   
//             }
//         });
//     }
//   )
// });

$(document).on('click', '.btnRangoInasistencia', function(){
  $('.rangoHorario').show();
  $('.inasistenciaIndividual').hide();
  $('.horarioIndividual').hide();
  $('.rangoInasistencia').hide();
  $('#daterange-btn').daterangepicker(
      {
        ranges   : {
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {
         $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
         var fechaInicial = start.format('DD/MM/YY');
         var fechaFinal = end.format('DD/MM/YY');
         var capturarRango = $("#daterange-btn span").html();

         // Valores para rango de sesion
         var idBeneficiario = $('.id_beneficiario').val();
         var cantidad = $('.cantidad').val();
         var fechas = fechaInicial+' - '+fechaFinal;
         var tipo = 'Inasistencia';
         var from = 'Calendar';
		 var mes = start.format('MM');
		 var anio = start.format('YYYY');
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
            url: host+"beneficiario/inasistencias",
           data: {id_beneficiario:idBeneficiario, cantidad:cantidad, fechas:fechas, agregarToForm:tipo, mes:mes, anio:anio},
            type: "POST",
            success: function(respuesta){
              if(respuesta.success){
                $('.inasistenciaSuccess').show();
                $('#inasistenciaSuccess').empty();
                $('#inasistenciaSuccess').append(respuesta.message);
                $('.appended-inasistencias').empty();
                $(respuesta.inasistencias).each(function(i, v){
                  $('.appended-inasistencias').append(`
                    <div class="row">
                      <div class="col-lg-12" style="margin-top: 5px;">
                        <div class="col-lg-3">
                          `+v['rango_fechas']+`
                        </div>
                        <div class="col-lg-3">
                          `+v['tipo']+`
                        </div>
                        <div class="col-lg-3">
                          <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  `);
                });
              }else{
                $('.inasistenciaFail').show();
                $('#inasistenciaFail').empty();
                $('#inasistenciaFail').append(respuesta.message);
              }   
            },
			 error:function(respuesta){
					console.log(respuesta);
						$('.inasistenciaFail').show();
						$('#inasistenciaFail').empty();
						$('#inasistenciaFail').append(respuesta.responseJSON['message']);
				}
        });
    }
  )
});

$(document).on('click', '.btnEliminarInasistencia', function(){
    var idFecha = $(this).attr('idInasistencia');
    idBenef = $(this).attr('idBenef');
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

     $.ajax({
          url: host+"beneficiario/inasistencias/delete",
          data: {id:idFecha, id_beneficiario:idBenef},
          type: "POST",
          success: function(respuesta){
            if(respuesta.success){
              $('.inasistenciaSuccess').show();
              $('#inasistenciaSuccess').empty();
              $('#inasistenciaSuccess').append(respuesta.message);
               $('.appended-inasistencias').empty();
                $(respuesta.inasistencias).each(function(i, v){
                  $('.appended-inasistencias').append(`
                    <div class="row">
                      <div class="col-lg-12" style="margin-top: 5px;">
                        <div class="col-lg-3">
                          `+v['rango_fechas']+`
                        </div>
                        <div class="col-lg-3">
                          `+v['tipo']+`
                        </div>
                        <div class="col-lg-3">
                          <button type="button" class="btn btn-danger btnEliminarInasistencia" idInasistencia="`+v['id']+`" idBenef="`+v['beneficiario_id']+`" style="padding: 3px 2px;"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  `);
                });
            }else{
              $('.inasistenciaFail').show();
              $('#inasistenciaFail').empty();
              $('#inasistenciaFail').append(respuesta.message);
            }   
          }
      });
});

$(document).on('click', '.btnTope', function(){
	var idBenef = $('.topeBenef').attr('idBenef');
	var value = $('.topeBenef').val();

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
		url: host+"beneficiario/tope",
		data: {id:idBenef, tope:value},
		type: "POST",
		success: function(respuesta){
			$('.topeBenef').val(value);
		}
	});
});

$(document).on('hidden.bs.modal', '#modalHorarioBeneficiario', function(){
    var idBenef = $('#tope').attr('idBenef');
	var benefNombre = $('#benefNombre').val();
	$('#tope').empty();
	$('.appended-inasistencias').empty();
	$('.inasistenciaFail').empty();
	$('.inasistenciaSuccess').empty();
	$('.beneficiarioBold').css('font-weight', 'normal');
	$('.beneficiarioBold[idBenef="'+idBenef+'"]').css('font-weight', 'bold');
	$('#searchbox').val(benefNombre).trigger('change');
	$('#dia').val(null).trigger('change');
});

$(document).on('click', '.topeRadio', function(){
	var val = $(this).val();
	if(val == "conTope"){
		var idBenef = $('#tope').attr('idBenef');
		var value = $('#tope').val();
		if(value == '' || value == null){
			$('.horarioSuccess').hide();
			$('.alertBenef').empty();
			$('.alertBenef').html('El tope no puede estar vacío. Por favor intente nuevamente.').show();
		}else{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: host+"beneficiario/tope",
				data: {id:idBenef, tope:value},
				type: "POST",
				success: function(respuesta){
					$('.topeBenef').val(value);
					$('.alertBenef').empty().hide();
					$('.horarioSuccess').show();
					$('#horarioSuccess').empty();
					$('#horarioSuccess').html('El tope ha sido cargado correctamente.');
				}
			});
		}

	}else{
		var idBenef = $('#tope').attr('idBenef');
		var value = null;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: host+"beneficiario/tope",
			data: {id:idBenef, tope:value},
			type: "POST",
			success: function(respuesta){
				$('.topeBenef').val('');
				$('.topeBenef').prop('placeholder', 'Sin tope');
			}
		});
	}
	hideAlerts();
})

$(document).on('change', '.selectTiempo', function(){
	var tiempoNombre = $(this).attr('id')
	if(tiempoNombre == "tiempoSesion"){
		$('#tiempoHoras').val('');
	}else{
		$('#tiempoSesion').val('');
	}
});