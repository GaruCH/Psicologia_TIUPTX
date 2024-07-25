<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Password extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_PASSWORD, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_PASSWORD;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/password", $this->cargar_datos());
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
		$datos['nombre_pagina'] = 'Cambiar Contraseña';

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Mi Perfil',
                          		'href' => route_to('mi_perfil'),
								'extra' => ''
                        	),
							array(
                          		'tarea' => 'Cambiar Contraseña',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Cambiar Mi Contraseña');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista,$contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	private function enviar_editar_usuario($email = NULL, $usuario = array(), $password_usuario = NULL) {
		$configuracion_correo = array();
		$configuracion_correo['asunto'] = 'Actualización de Contraseña';
		$configuracion_correo['background_header'] = '#542772;';
		$configuracion_correo['logo'] = base_url(IMG_DIR_SISTEMA.'/'.LOGO_SISTEMA_CJM);
		$configuracion_correo['usuario'] = $usuario;
		$configuracion_correo['password'] = $password_usuario;
		$configuracion_correo['rol_usuario'] = ROLES[$usuario["id_rol"]];
		$configuracion_correo['header'] = 'Datos Generales del Usuario';
		$configuracion_correo['descripcion'] = 'Te proporcionamos tus credenciales de acceso actualizadas para el SiAdCJM.';
		$configuracion_correo['acronimo_sistema'] = ACRONIMO_SISTEMA;
		$plantilla_email = view('plantilla/email_base', $configuracion_correo);
		return enviar_correo_individual(CORREO_EMISOR_SISTEMA, ACRONIMO_SISTEMA , $email, $configuracion_correo['asunto'], $plantilla_email);
	}//end enviar_editar_usuario

	public function actualizar(){
		if($this->permitido){
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$id_usuario = session()->id_usuario;
			$usuario = array();
			$actual_password = hash('sha256', $this->request->getPost('actual_password'));
			$data = $tabla_usuarios->select('nombre_usuario, ap_paterno_usuario, ap_materno_usuario, email_usuario, id_rol')->find($id_usuario);
			if($actual_password == $tabla_usuarios->select('password_usuario')->find($id_usuario)->password_usuario){
				$usuario['password_usuario'] = hash('sha256', $this->request->getPost('confirm_password'));
				if($usuario['password_usuario'] == $actual_password){
					mensaje("Tu nueva contraseña no puede ser igual a la antigua contraseña", WARNING_ALERT, "¡Contraseña No Cambiada!");
					return redirect()->to(route_to('cambiar_password'));
				}//end if password es la misma
				else{
					$tabla_usuarios->update($id_usuario, $usuario);
					$this->enviar_editar_usuario($data->email_usuario, covert_stdlclass_to_array($data), $this->request->getPost('confirm_password'));
					mensaje("Tu contraseña se ha actualizado exitosamente", SUCCESS_ALERT, "¡Contraseña Actualizada!");
					return redirect()->to(route_to('cambiar_password'));
				}//end else
			}//end if el password coincide
			else{
				mensaje("La contraseña actual proporcionada es incorrecta", DANGER_ALERT, "¡Contraseña Actual Incorrecta!");
				return redirect()->to(route_to('cambiar_password'));
			}//end else el pass no coincide
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end actualizar

}//End Class Password
