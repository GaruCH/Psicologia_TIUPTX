<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Ejemplo extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_EJEMPLO, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol permitido
		else{
			$session->tarea_actual = TAREA_EJEMPLO;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/ejemplo", $this->cargar_datos());
		}//end if rol permitido
		else{
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos(){
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
		$datos['nombre_pagina'] = 'Ejemplo';

		//Breadcrumb
    	$datos['breadcrumb'] = '';

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

}//End Class Dashboard
