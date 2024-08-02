<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Usuario\Login::index',['as' => 'login']);
//******************************************************************************
//******************** RUTAS DEL PANEL DE ADMINISTRACIÓN ***********************
//******************************************************************************

//Correo Electronico
//$routes->get('/enviar_correo', 'Panel\Correo::send_mail', ['as' => 'enviar_correo']);

//Login
$routes->get('/login', 'Usuario\Login::index', ['as' => 'login']);
$routes->post('/validar_usuario', 'Usuario\Login::comprobar', ['as' => 'validar_usuario']);
$routes->get('/logout', 'Usuario\Logout::index', ['as' => 'logout']);
//Forgot Password
$routes->get('/recuperar_contraseña', 'Usuario\Forgot::index', ['as' => 'recuperar_contraseña']);
$routes->post('/recuperar_contrasena', 'Usuario\Forgot::recuperarC', ['as' => 'recuperar_contrasena']);
$routes->get('/restaurar_contrasena/(:any)', 'Usuario\Forgot::reset_password/$1', ['as' => 'restaurar_contrasena']);
$routes->post('/actualizar_contrasena', 'Usuario\Forgot::update_password', ['as' => 'actualizar_contrasena']);
//Register
$routes->get('/registro_paciente', 'Usuario\Register::index', ['as' => 'registro_paciente']);
$routes->post('/registrar_paciente_alumno', 'Usuario\Register::registrar_alumno', ['as' => 'registrar_paciente_alumno']);
$routes->post('/registrar_paciente_administrativo', 'Usuario\Register::registrar_administrativo', ['as' => 'registrar_paciente_administrativo']);
$routes->post('/registrar_paciente_invitado', 'Usuario\Register::registrar_invitado', ['as' => 'registrar_paciente_invitado']);
//Propios del perfil
$routes->get('/mi_perfil', 'Panel\Perfil::index', ['as' => 'mi_perfil']);
$routes->post('/editar_mi_perfil', 'Panel\Perfil::actualizar', ['as' => 'editar_mi_perfil']);
$routes->get('/cambiar_password', 'Panel\Password::index', ['as' => 'cambiar_password']);
$routes->post('/editar_password', 'Panel\Password::actualizar', ['as' => 'editar_password']);
//Dashboard para diferentes roles
$routes->get('/dashboard', 'Panel\Dashboard::index', ['as' => 'dashboard']);
$routes->get('/dashboard_paciente', 'Panel\Dashboard_paciente::index', ['as' => 'dashboard_paciente']);
$routes->get('/dashboard_psicologo', 'Panel\Dashboard_psicologo::index', ['as' => 'dashboard_psicologo']);
//Usuarios
$routes->get('/administracion_usuarios', 'Panel\Usuarios::index', ['as' => 'administracion_usuarios']);
$routes->post('/estatus_usuario', 'Panel\Usuarios::estatus', ['as' => 'estatus_usuario']);
$routes->post('/eliminar_usuario', 'Panel\Usuarios::eliminar', ['as' => 'eliminar_usuario']);
$routes->post('/restaurar_usuario', 'Panel\Usuarios::recuperar_usuario', ['as' => 'restaurar_usuario']);
$routes->post('/actualizar_password', 'Panel\Usuarios::actualizar_password', ['as' => 'actualizar_password']);
$routes->get('/nuevo_usuario', 'Panel\Usuario_nuevo::index', ['as' => 'nuevo_usuario']);
$routes->post('/registrar_usuario', 'Panel\Usuario_nuevo::registrar', ['as' => 'registrar_usuario']);
$routes->get('/detalles_usuario/(:num)', 'Panel\Usuario_detalles::index/$1', ['as' => 'detalles_usuario']);
$routes->post('/editar_usuario', 'Panel\Usuario_detalles::editar', ['as' => 'editar_usuario']);
//ejemplo
$routes->get('/ejemplo', 'Panel\Ejemplo::index', ['as' => 'ejemplo']);
//Psicologos
$routes->get('/administracion_psicologos', 'Panel\Psicologos::index', ['as' => 'administracion_psicologos']);
$routes->get('/obtener_psicologos', 'Panel\Psicologos::generar_datatable_psicologos', ['as' => 'obtener_psicologos']);
$routes->post('/estatus_psicologo', 'Panel\Psicologos::estatus_psicologo', ['as' => 'estatus_psicologo']);
$routes->post('/eliminar_psicologo', 'Panel\Psicologos::eliminar_psicologo', ['as' => 'eliminar_psicologo']);
$routes->post('/restaurar_psicologo', 'Panel\Psicologos::recuperar_psicologo', ['as' => 'restaurar_psicologo']);
$routes->post('/actualizar_password_psicologo', 'Panel\Psicologos::actualizar_password_psicologo', ['as' => 'actualizar_password_psicologo']);
$routes->post('/registrar_psicologo', 'Panel\Psicologos::registrar_psicologo', ['as' => 'registrar_psicologo']);
$routes->get('/obtener_psicologo/(:num)', 'Panel\Psicologos::obtener_datos_psicologo/$1', ['as' => 'obtener_psicologo']);
$routes->post('/editar_psicologo', 'Panel\Psicologos::editar_psicologo', ['as' => 'editar_psicologo']);

//Paciente

//Horarios_Psicologos
$routes->get('/administracion_horarios', 'Panel\Horarios::index', ['as' => 'administracion_horarios']);
$routes->get('/obtener_horario', 'Panel\Horarios::generar_datatable_horario', ['as' => 'obtener_horario']);
$routes->post('/estatus_horario', 'Panel\Horarios::estatus_horario', ['as' => 'estatus_horario']);
$routes->post('/registrar_horario', 'Panel\Horarios::registrar_horario', ['as' => 'registrar_horario']);
$routes->post('/editar_horario', 'Panel\Horarios::actualizar_horas', ['as' => 'editar_horario']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
