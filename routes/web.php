<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ImportesController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\PresupuestosController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UsersController;


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
    return view('login');
});
// Route::get('/verificationLogIn', function () {
//     dd($_POST['email']);
// });
Route::get('/forgot-pwd', function () {
    return view('forgot-pwd');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/table', function () {
    return view('table');
});
Route::get('/historico_presupuesto', function () {
    return view('historico_presupuesto');
});
Route::get('/ventas_presupuesto', function () {
    return view('ventas_presupuesto');
});
Route::get('/admin_tarifas', function () {
    return view('admin_tarifas');
});
Route::get('/pruebaOPT', function () {
    return view('pruebaOPT');
});
Route::get('/clientes_crear', function () {
    return view('clientes_crear');
});

Route::get('table',                                 [ImportesController::class, 'showImporte']);
Route::post('IntroducirDatos',                      [ImportesController::class, 'introducirDatos']);
Route::post('generarPDF',                           [PDFController::class, 'generarPDF']);
Route::post('intermedioPDF',                        [PDFController::class, 'intermedio']);
Route::get('intermedioPDF/{pre_id}',                [PDFController::class, 'intermedioID']);

Route::get('form_presupuesto',                      [PresupuestosController::class, 'consultarPresupuesto']);
Route::get('crear_accion_comercial',                [PresupuestosController::class, 'consultarPresupuestoAccionCom']);
Route::get('admin_accion_comercial',                [PresupuestosController::class, 'consultarAccionComercial']);
Route::get('buzon_presupuesto',                     [PresupuestosController::class, 'showBuzon']);
Route::get('modificarPresupuesto/{pre_id}',         [PresupuestosController::class, 'consultarPresupuestoID']);
Route::get('modificarAccCom/{pre_id}',              [PresupuestosController::class, 'consultarAccionComercialID']);
Route::get('historico_presupuesto',                 [PresupuestosController::class, 'obtenerPresupuestos_historico']);
Route::get('ventas_presupuesto',                    [PresupuestosController::class, 'obtenerPresupuestos_ventas']);
Route::get('admin_tarifas',                         [PresupuestosController::class, 'consultarPresupuestoAdmin']);
Route::get('PresupuestoDesdeAcc/{id_cli}/{id_acc}', [PresupuestosController::class, 'crearDesdeAcc']);
Route::get('presupuesto_ficha/{pre_id}',            [PresupuestosController::class, 'fichaPresupuesto']);
Route::get('copiarPresupuesto/{pre_id}',            [PresupuestosController::class, 'copiarPresupuestoID']);
Route::post('guardar_accion_comercial',             [PresupuestosController::class, 'guardar_accion_comercial']);
Route::post('eliminarAcc',                          [PresupuestosController::class, 'eliminar_accion_comercial']);
Route::post('editar_tarifas',                       [PresupuestosController::class, 'editarTarifas']);
Route::post('guardar_presupuesto',                  [PresupuestosController::class, 'guardar_presupuesto']);
Route::post('aceptar_presupuesto',                  [PresupuestosController::class, 'aceptar_presupuesto']);
Route::post('rechazar_presupuesto',                 [PresupuestosController::class, 'rechazar_presupuesto']);
Route::post('filtrar_historico',                    [PresupuestosController::class, 'filtrar_historico']);
Route::post('filtrar_ventas',                       [PresupuestosController::class, 'filtrar_ventas']);
Route::post('datos_anunciante',                     [PresupuestosController::class, 'datos_anunciante']);
Route::get('mail/{pre_id}',                         [PresupuestosController::class, 'mail']);

Route::get('clientes_tabla',                        [ClientesController::class, 'listaClientes']);
Route::get('potenciales_tabla',                     [ClientesController::class, 'listaPotenciales']);
Route::get('clientes_buzon',                        [ClientesController::class, 'buzonClientes']);
Route::get('clientes_bajas',                        [ClientesController::class, 'bajasClientes']);
Route::get('clientes_cartera',                      [ClientesController::class, 'carteraClientes']);
Route::get('crear_presupuesto/{cli_id}',            [ClientesController::class, 'crearPresupuesto']);
Route::get('clientes_ficha/{cli_id}',               [ClientesController::class, 'consultarCliente']);
Route::get('aceptar_cliente/{cli_id}',              [ClientesController::class, 'aceptarCliente']);
Route::get('crear_presupuestoAcc/{cli_id}',         [ClientesController::class, 'crearPresupuestoAcc']);
Route::get('dar_baja_cliente/{cli_id}',             [ClientesController::class, 'darBajaCliente']);
Route::get('sol_baja_cliente/{cli_id}',             [ClientesController::class, 'solBajaCliente']);
Route::get('rec_baja_cliente/{cli_id}',             [ClientesController::class, 'recBajaCliente']);
Route::get('ver_cliente/{cli_nom}',                 [ClientesController::class, 'verCliente']);
Route::get('agenda',                                [ClientesController::class, 'showAgenda']);
Route::post('DatosDonut',                           [ClientesController::class, 'datosDonut']);
Route::post('rechazar_cliente',                     [ClientesController::class, 'rechazarCliente']);
Route::post('val_comercial',                        [ClientesController::class, 'validacionComercial']);
Route::post('val_admin',                            [ClientesController::class, 'validacionAdmin']);
Route::post('agendar_cliente',                      [ClientesController::class, 'agendarCliente']);
Route::post('modificar_cliente',                    [ClientesController::class, 'modificarCliente']);
Route::post('crear_cliente',                        [ClientesController::class, 'crearCliente']);
Route::post('carterizar_cliente',                   [ClientesController::class, 'carterizarCliente']);
Route::post('cambiarEvento',                        [ClientesController::class, 'cambioEvento']);
Route::post('add_registro',                         [ClientesController::class, 'addRegistro']);
Route::post('filtrar_clientes',                     [ClientesController::class, 'filtrarClientes']);
Route::post('datos_clientes',                       [ClientesController::class, 'datos_clientes']);
Route::post('filtrar_clientes_bajas',               [ClientesController::class, 'filtrarBajas']);
Route::post('traspasar_cliente',                    [ClientesController::class, 'traspasarCliente']);

Route::get('admin_users',                           [UsersController::class,    'listaUsers']);
Route::get('users_info/{user_id}/{mes?}/{anyo?}',   [UsersController::class,    'consultarUsuario']);
Route::get('users_ratio/{user_id}',                 [UsersController::class,    'ratiosUsuario']);
Route::get('analisis_cartera/{user_id?}',           [UsersController::class,    'analisis_cartera']);
Route::post('verificationLogIn',                    [UsersController::class,    'verificationLogIn']);
Route::get('cerrar_sesion',                         [UsersController::class,    'EndSession']);
