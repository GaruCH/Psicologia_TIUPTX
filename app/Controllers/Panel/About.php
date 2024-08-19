<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class About extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_ABOUT, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol permitido
		else{
			$session->tarea_actual = TAREA_ABOUT;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/about", $this->cargar_datos());
		}//end if rol permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos()
	{
		//======================================================================
		//==========================DATOS FUNDAMENTALES=========================
		//======================================================================

		$datos = array();
		$session = session();
		$datos['nombre_completo_usuario'] = $session->nombre_completo_usuario;
		$datos['email_usuario'] = $session->email_usuario;
		$datos['imagen_usuario'] = ($session->imagen_usuario == NULL ?
			($session->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') :
			$session->imagen_usuario);



		//======================================================================
		//========================DATOS PROPIOS CONTROLLER======================
		//======================================================================

		$tabla_roles = new \App\Models\Tabla_roles;
		$datos['roles'] = $tabla_roles->obtener_roles($session->rol_actual['clave']);


		$datos['nombre_pagina'] = 'Información del gestor';

		//Breadcrumb
		$navegacion = array(
			array(
				'tarea' => 'Información GIPP',
				'href' => '#'
			)
		);

		$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Información del gestor');

		// Cargar notificaciones utilizando el helper
		$datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

		return $datos;
	} //end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array())
	{
		$session = session();

		$perfil = cargarPerfilUsuario($session);

		// Combinar el contenido existente con el perfil de usuario
		$contenido = array_merge($contenido, $perfil);
		
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	} //end crear_vista
}