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
//**************************** RUTAS GENERALES *********************************
//******************************************************************************



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


//******************************************************************************
//*************************** RUTAS DEL SUPERADMIN *****************************
//******************************************************************************


$routes->group('/superadmin', function ($routes) {
    // Dashboard para Superadmin
    $routes->get('dashboard', 'Panel\Dashboard_superadmin::index', ['as' => 'dashboard_superadmin']);

    // Usuarios - Superadmin
    $routes->get('usuarios', 'Panel\Usuarios::index', ['as' => 'administrar_usuarios']);
    $routes->get('usuarios/data', 'Panel\Usuarios::generar_datatable_usuarios', ['as' => 'obtener_usuarios']);
    $routes->post('usuarios/estatus', 'Panel\Usuarios::estatus_usuario', ['as' => 'cambiar_estatus_usuario']);
    $routes->post('usuarios/eliminar', 'Panel\Usuarios::eliminar_usuario', ['as' => 'eliminar_usuario']);
    $routes->post('usuarios/restaurar', 'Panel\Usuarios::recuperar_usuario', ['as' => 'restaurar_usuario']);
    $routes->post('usuarios/actualizar-password', 'Panel\Usuarios::actualizar_password_usuario', ['as' => 'actualizar_password_usuario']);
    $routes->post('usuarios/registrar', 'Panel\Usuarios::registrar_usuario', ['as' => 'registrar_usuario']);
    $routes->get('usuarios/(:num)', 'Panel\Usuarios::obtener_datos_usuario/$1', ['as' => 'obtener_usuario']);
    $routes->post('usuarios/editar', 'Panel\Usuarios::editar_usuario', ['as' => 'editar_usuario']);

    // Ejemplo
    $routes->get('ejemplo', 'Panel\Ejemplo::index', ['as' => 'ejemplo']);
	//Notificaciones
	$routes->post('confirmar_notificacion', 'Panel\Notificaciones_panel::marcar_como_leido', ['as' => 'confirmar_notificacion_superadmin']);
});




//******************************************************************************
//******************************** RUTAS DEL ADMIN *****************************
//******************************************************************************




$routes->group('/admin', function ($routes) {
    // Dashboard para Administrador
    $routes->get('dashboard', 'Panel\Dashboard_admin::index', ['as' => 'dashboard_admin']);

    // Psicólogos - Admin
    $routes->get('psicologos', 'Panel\Psicologos::index', ['as' => 'administrar_psicologos']);
    $routes->get('psicologos/data', 'Panel\Psicologos::generar_datatable_psicologos', ['as' => 'obtener_psicologos']);
    $routes->post('psicologos/estatus', 'Panel\Psicologos::estatus_psicologo', ['as' => 'cambiar_estatus_psicologo']);
    $routes->post('psicologos/eliminar', 'Panel\Psicologos::eliminar_psicologo', ['as' => 'eliminar_psicologo']);
    $routes->post('psicologos/restaurar', 'Panel\Psicologos::recuperar_psicologo', ['as' => 'restaurar_psicologo']);
    $routes->post('psicologos/actualizar-password', 'Panel\Psicologos::actualizar_password_psicologo', ['as' => 'actualizar_password_psicologo']);
    $routes->post('psicologos/registrar', 'Panel\Psicologos::registrar_psicologo', ['as' => 'registrar_psicologo']);
    $routes->get('psicologos/(:num)', 'Panel\Psicologos::obtener_datos_psicologo/$1', ['as' => 'obtener_psicologo']);
    $routes->post('psicologos/editar', 'Panel\Psicologos::editar_psicologo', ['as' => 'editar_psicologo']);

    // Cambiar Asignaciones de Pacientes - Admin
    $routes->get('asignaciones', 'Panel\Asignaciones::index', ['as' => 'administrar_asignaciones']);
    $routes->get('asignaciones/data', 'Panel\Asignaciones::generar_datatable_asignaciones', ['as' => 'obtener_asignaciones']);
    $routes->get('asignaciones/(:num)', 'Panel\Asignaciones::obtener_datos_asignacion/$1', ['as' => 'obtener_asignacion']);
    $routes->post('asignaciones/editar', 'Panel\Asignaciones::actualizar_asignacion', ['as' => 'editar_asignacion']);
	//Notificaciones
	$routes->post('confirmar_notificacion', 'Panel\Notificaciones_panel::marcar_como_leido', ['as' => 'confirmar_notificacion_admin']);
});



//******************************************************************************
//**************************** RUTAS DEL PSICÓLOGO *****************************
//******************************************************************************



//Psicólogos
$routes->group('/psicologo', function ($routes) {
    // Dashboard del Psicólogo
    $routes->get('dashboard', 'Panel\Dashboard_psicologo::index', ['as' => 'dashboard_psicologo']);

    // Horarios de Psicólogos
    $routes->get('horarios', 'Panel\Horarios::index', ['as' => 'administrar_horarios_psicologo']);
    $routes->get('horarios/data', 'Panel\Horarios::generar_datatable_horario', ['as' => 'obtener_datos_horarios']);
    $routes->post('horarios/estatus', 'Panel\Horarios::estatus_horario', ['as' => 'actualizar_estatus_horario']);
    $routes->post('horarios/registrar', 'Panel\Horarios::registrar_horario', ['as' => 'registrar_horario']);
    $routes->post('horarios/editar', 'Panel\Horarios::actualizar_horas', ['as' => 'editar_horario']);

    // Citas del Psicólogo
    $routes->get('citas', 'Panel\Psicologo_citas::index', ['as' => 'administrar_citas_psicologo']);
    $routes->get('citas/data', 'Panel\Psicologo_citas::generar_datatable_citas', ['as' => 'obtener_datos_citas']);
    $routes->post('citas/aceptar', 'Panel\Psicologo_citas::cambiar_estatus_cita_aceptar', ['as' => 'aceptar_cita']);
    $routes->post('citas/cancelar', 'Panel\Psicologo_citas::cambiar_estatus_cita_cancelar', ['as' => 'cancelar_cita']);
    $routes->post('citas/concluir', 'Panel\Psicologo_citas::cambiar_estatus_cita_concluir', ['as' => 'concluir_cita']);
    $routes->get('citas/horas-disponibles/(:num)/(:num)/(:segment)', 'Panel\Psicologo_citas::obtener_horas_disponibles/$1/$2/$3', ['as' => 'horas_disponibles_psicologo']);
    $routes->get('citas/verificar-fecha/(:num)/(:num)', 'Panel\Psicologo_citas::verificar_fecha_valida/$1/$2', ['as' => 'verificar_fecha_cita']);
    $routes->post('citas/registrar', 'Panel\Psicologo_citas::registrar_cita', ['as' => 'registrar_cita_psicologo']);

    // Historial de Pacientes
    $routes->get('pacientes/historial', 'Panel\Historial_psicologo::index', ['as' => 'historial_pacientes_psicologo']);
    $routes->get('pacientes/historial/data', 'Panel\Historial_psicologo::generar_datatable_historial_pacientes', ['as' => 'obtener_historial_pacientes']);

    // Historial de Citas
    $routes->get('citas/historial', 'Panel\Historial_psicologo_citas::index', ['as' => 'historial_citas_psicologo']);
    $routes->get('citas/historial/data', 'Panel\Historial_psicologo_citas::generar_datatable_historial_citas', ['as' => 'obtener_historial_citas_psicologo']);

    // Pacientes del Psicólogo
    $routes->get('pacientes', 'Panel\Psicologos_paciente::index', ['as' => 'administrar_pacientes_psicologo']);
    $routes->get('pacientes/data', 'Panel\Psicologos_paciente::generar_datatable_psicologo_pacientes', ['as' => 'obtener_datos_pacientes']);
    $routes->get('pacientes/(:num)', 'Panel\Psicologos_paciente::obtener_datos_paciente/$1', ['as' => 'obtener_paciente']);

	//Notificaciones
	$routes->post('confirmar_notificacion', 'Panel\Notificaciones_panel::marcar_como_leido', ['as' => 'confirmar_notificacion_psicologo']);
});

//******************************************************************************
//**************************** RUTAS DEL PACIENTE *****************************
//******************************************************************************


//Pacientes
$routes->group('/paciente', function ($routes) {
    // Dashboard del Paciente
    $routes->get('dashboard', 'Panel\Dashboard_paciente::index', ['as' => 'dashboard_paciente']);

    // Citas del Paciente
    $routes->get('citas', 'Panel\Paciente_citas::index', ['as' => 'administrar_citas_paciente']);
    $routes->get('citas/data', 'Panel\Paciente_citas::generar_datatable_citas', ['as' => 'obtener_datos_citas_paciente']);
    $routes->post('citas/eliminar', 'Panel\Paciente_citas::eliminar_cita', ['as' => 'eliminar_cita_paciente']);
    $routes->get('citas/horas-disponibles/(:num)/(:num)/(:segment)', 'Panel\Paciente_citas::obtener_horas_disponibles/$1/$2/$3', ['as' => 'horas_disponibles_paciente']);
    $routes->get('citas/verificar-fecha/(:num)/(:num)', 'Panel\Paciente_citas::verificar_fecha_valida/$1/$2', ['as' => 'verificar_fecha_cita_paciente']);
    $routes->post('citas/registrar', 'Panel\Paciente_citas::registrar_cita', ['as' => 'registrar_cita_paciente']);

    // Historial de Citas del Paciente
    $routes->get('citas/historial', 'Panel\Historial_paciente_citas::index', ['as' => 'historial_citas_paciente']);
    $routes->get('citas/historial/data', 'Panel\Historial_paciente_citas::generar_datatable_historial_citas', ['as' => 'obtener_historial_citas_paciente']);
	//Notificaciones
	$routes->post('confirmar_notificacion', 'Panel\Notificaciones_panel::marcar_como_leido', ['as' => 'confirmar_notificacion_paciente']);
});

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
