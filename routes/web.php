<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('change-password', 'ChangePasswordController@index')->name('pass');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware('guest')->name('password.request');
// Prestador
Route::get('/prestadores', 'PrestadorController@index')->name('prestadores');
Route::get('/datos-prestador', 'PrestadorController@data')->name('datos-prestador');
Route::post('/prestador/create', 'PrestadorController@create')->name('prestador-create');
Route::post('/prestador/update', 'PrestadorController@update')->name('prestador-update');
Route::post('/prestador/list', 'PrestadorController@list')->name('prestador-list');
Route::get('/prestador/destroy/{id}', 'PrestadorController@destroy')->name('prestador-destroy');

// Usuario
Route::post('/usuario/update', 'UserController@update')->name('update-usuario');
Route::get('/user/bloquear/{id}', 'UserController@bloquear')->name('bloquear-usuario');
Route::get('/user/desbloquear/{id}', 'UserController@desbloquear')->name('desbloquear-usuario');


// Obra Social
Route::get('/obrasocial', 'ObraSocialController@index')->name('obra-social');
Route::post('obrasocial/create', 'ObraSocialController@create')->name('os-create');
Route::post('obrasocial/update', 'ObraSocialController@update')->name('os-update');
Route::post('/obrasocial/list', 'ObraSocialController@list')->name('os-list');

// Beneficiario
Route::get('/beneficiarios/{prestador_id}/{obrasocial_id}/{mes?}/{anio?}', 'BeneficiarioController@index')->name('beneficiarios');
Route::get('/beneficiarios-inactivos/{prestador_id}', 'BeneficiarioController@beneficiariosInactivos')->name('beneficiarios.inactivos');
Route::post('/beneficiarios/create', 'BeneficiarioController@create')->name('beneficiario-create');
Route::post('beneficiario/list', 'BeneficiarioController@list')->name('beneficiario-list');
Route::get('beneficiario/presupuesto/{prestador_id}/{beneficiario_id}', 'BeneficiarioController@presupuesto')->name('beneficiario-presupuesto');
Route::get('beneficiario/presupuesto/traslado/{prestador_id}/{beneficiario_id}', 'BeneficiarioController@presupuestoTraslado')->name('beneficiario-presupuesto-traslado');
Route::post('beneficiario/update', 'BeneficiarioController@update')->name('beneficiario-update');
Route::get('/beneficiario/form/{id}/{prestador_id}/{planilla}/{mes?}/{anio?}', 'BeneficiarioController@formulario')->name('formulario-beneficiario');
Route::get('/beneficiario/delete/{os_id}/{beneficiario_id}', 'BeneficiarioController@delete')->name('beneficiario-delete');
Route::get('/beneficiario-inactivo/delete/{os_id}/{beneficiario_id}', 'BeneficiarioController@beneficiarioInactivoDelete')->name('beneficiario-inactivo-delete');
Route::get('/inactivo/delete/{os_id}/{beneficiario_id}', 'BeneficiarioController@InactivoDelete')->name('inactivo-delete');
Route::get('/beneficiario/status/{id}/{id_os}/{status}', 'BeneficiarioController@status')->name('beneficiario-status');
Route::get('/beneficiario-inactivo/status/{id}/{id_os}/{status}', 'BeneficiarioController@inactiveStatus')->name('beneficiario-inactivo-status');
Route::post('/beneficiario-inactivo/cambiar', 'BeneficiarioController@inactiveStatus')->name('beneficiario-inactivo-cambiar');
Route::post('/beneficiario/traditum', 'BeneficiarioController@traditum')->name('beneficiario-traditum');
Route::post('/beneficiario/inasistencias', 'InasistenciaController@store')->name('beneficiario-inasistencias');
Route::post('/beneficiario/inasistenciasBeneficiario', 'InasistenciaController@show')->name('beneficiario-inasistencias-beneficiario');
Route::post('/beneficiario/inasistencias/delete', 'InasistenciaController@destroy')->name('beneficiario-inasistencias-destroy');
Route::post('/beneficiario/tope', 'BeneficiarioController@tope')->name('beneficiario-tope');
Route::get('/beneficiario/planilla/{prestador_id}/{os}/{mes?}/{anio?}', 'BeneficiarioController@planillaFacturacion')->name('beneficiario-planilla-facturacion');
Route::get('/beneficiario/planilla/traslado/{prestador_id}/{os}/{mes?}/{anio?}', 'BeneficiarioController@planillaFacturacionTraslado')->name('beneficiario-planilla-facturacion-traslado');
Route::get('/beneficiario/planilla/asistencia/{prestador_id}/{os}/{mes?}/{anio?}', 'BeneficiarioController@planillaAsistenciaTraslado')->name('beneficiario-planilla-asistencia');

//Prestaciones
Route::get('/prestaciones', 'ObraSocialController@lista_prestaciones')->name('prestaciones');
Route::post('/prestacion/create', 'ObraSocialController@create_prestacion')->name('prestacion-create');
Route::get('/prestacion/show/{id}', 'PrestacionController@show')->name('prestacion-show');
Route::post('/prestacion/edit', 'ObraSocialController@edit')->name('prestacion-edit');
Route::get('/prestacionind/show/{id}', 'ObraSocialController@show')->name('prestacion-ind-show');
Route::get('/prestacion/delete/{id}', 'PrestacionController@destroy')->name('prestacion-delete');

// Sesiones
Route::post('/sesion/horarios', 'SesionController@index')->name('sesion-horarios');
Route::post('/sesion/create', 'SesionController@store')->name('sesion-create');
Route::post('/sesion/destroy', 'SesionController@destroy')->name('sesion-destroy');

// Users
Route::get('/admin/users', 'UserController@showSystemUsers')->name('admin-users');
Route::post('/user/month', 'UserController@saveUserMonth')->name('user-month');
Route::post('/user/year', 'UserController@saveUserYear')->name('user-year');
Route::post('/user/list', 'UserController@list')->name('user-list');
Route::get('/user/delete/{id}', 'UserController@destroy')->name('user-destroy');

// Video tutoriales
Route::get('/video/tutorials', 'VideoController@index')->name('video-tutorials');
Route::post('/video/create', 'VideoController@store')->name('video-create');
Route::post('/video/update', 'VideoController@update')->name('video-update');
Route::post('/video/list', 'VideoController@list')->name('video-list');
Route::get('/video/delete/{id}', 'VideoController@destroy')->name('video-destroy');

// Contrato
Route::get('/contrato', 'ContratoController@index')->name('contrato');
Route::post('/contrato/create', 'ContratoController@store')->name('contrato-create');
Route::post('/contrato/update', 'ContratoController@update')->name('contrato-update');
Route::post('/contrato/list', 'ContratoController@list')->name('contrato-list');
Route::get('/contrato/delete/{id}', 'ContratoController@destroy')->name('contrato-destroy');

// Feriados
Route::get('/feriados', 'FeriadoController@index')->name('feriados');
Route::post('/feriado/create', 'FeriadoController@store')->name('feriado-store');
Route::post('/feriado/update', 'FeriadoController@update')->name('feriado-update');
Route::get('/feriado/delete/{id}', 'FeriadoController@destroy')->name('feriado-delete');

// Mensajes
Route::get('/mensajes', 'MensajeController@index')->name('mensajes');
Route::get('/mensajes/recibidos', 'MensajeController@index2')->name('mensajes-recibidos');
Route::post('/mensajes/create', 'MensajeController@create')->name('mensajes-store');
Route::post('/mensajes/update', 'MensajeController@update')->name('mensajes-update');
Route::get('/mensajes/delete/{id}/{redir}', 'MensajeController@destroy')->name('mensajes-delete');


// Facturacion Electronica certificados

Route::post('/facturacion/electronica/certificados/store', 'FacturacionElectronicaCertificadoController@store')->name('facturacion.electronica.certificado.store');
Route::post('/facturacion/electronica/certificados/key/store', 'FacturacionElectronicaCertificadoController@storeKey')->name('facturacion.electronica.key.store');
Route::post('/facturacion/electronica/certificados/update', 'FacturacionElectronicaCertificadoController@update')->name('facturacion.electronica.update');
Route::post('/facturacion/electronica/certificados/generate', 'FacturacionElectronicaCertificadoController@generate')->name('facturacion.electronica.cert.generate');

//Abm de cetificados de afip
Route::resource('/certs', 'CertificadosController');

// Facturacion Electronica

Route::resource('facturacion', 'FacturacionController');
Route::get('/consultafactura', 'FacturacionController@consultafactura')->name('consultafactura');


Route::get('/fact', 'FacturacionController@facturaelectronica')->name('facturacion.ws');
Route::get('/cae', 'FacturacionController@cae')->name('soli');


Route::get('/prefactura', 'FacturacionController@indexfactura')->name('previaFactura');
Route::get('/pre', 'FacturacionController@indexfactura')->name('prefacturas');


/* Route::post('/consultarcuit', 'FacturacionController@consultarcuit')->name('solicitarcae'); */
Route::get('/caesolicitud', 'FacturacionController@caesolicitud')->name('caesolicitud');
Route::post('/consultafactura', 'FacturacionController@consultafactura')->name('consultafactura');




// Sys
Route::get('/updateapp', function()
{
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});
