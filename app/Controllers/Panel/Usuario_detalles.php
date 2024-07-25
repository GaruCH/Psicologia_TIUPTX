<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Usuario_detalles extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_USUARIO_DETALLES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_USUARIO_DETALLES;
		}//end else rol permitido
	}//end constructor

	public function index($id_usuario = 0){
		if($this->permitido){
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$usuario = $tabla_usuarios->obtener_usuario($id_usuario);
			if($usuario == NULL){
				mensaje('No se encuentra al usuario propocionado.', WARNING_ALERT, '¡Usuario no encontrado!');
				return redirect()->to(route_to('administracion_usuarios'));
			}//end if no existe el usuario
			else{
				$session = session();
				if($session->rol_actual['clave'] != ROL_SUPERADMIN['clave'] && $usuario->id_rol == ROL_SUPERADMIN['clave'] ||
				  ($usuario->id_usuario == $session->id_usuario || $session->rol_actual['clave'] == $usuario->id_rol)){
					mensaje('No se tienen permisos para acceder a este registro.', WARNING_ALERT, '¡Acceso no autorizado!');
					return redirect()->to(route_to('administracion_usuarios'));
				}//end if es un usuario que quiere editar su propio user O si es un usuario distinto del superadmin O si es un usuario cuyo rol es igual al del rol que quiere editar
				else{
					return $this->crear_vista("panel/usuario_detalles", $this->cargar_datos($usuario));
				}//end else
			}//end else no existe el usuario
		}//end if rol permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso no autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos($usuario = NULL){
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
		$datos['nombre_pagina'] = 'Detalles usuario';
		//Cargar modelos
		$tabla_roles = new \App\Models\Tabla_roles;
		$datos['roles'] = $tabla_roles->obtener_roles($session->rol_actual['clave']);
		$datos['usuario'] = $usuario;

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Usuarios',
                          		'href' => route_to('administracion_usuarios'),
								'extra' => ''
                        	),
							array(
                          		'tarea' => 'Detalles usuario',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Detalles del usuario: <b>'.$usuario->nombre_usuario.' '.
															 $usuario->ap_paterno_usuario.' '.
															 $usuario->ap_materno_usuario.'</b>');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	private function enviar_editar_usuario($email = NULL, $usuario = array(), $password_usuario = NULL) {
		$configuracion_correo = array();
		$configuracion_correo['asunto'] = 'Información de actualización';
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

	public function editar(){
		if($this->permitido){
			$id_usuario = $this->request->getPost('id_usuario');

			if($this->request->getPost('sexo') == NULL){
				mensaje("Debes seleccionar un sexo para el usuario", DANGER_ALERT, "¡No se pudo registrar!");
				return $this->index($id_usuario);
			}//end if no existe sexo seleccionado
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$usuario = array();
			$usuario['nombre_usuario'] = $this->request->getPost('nombre');
			$usuario['ap_paterno_usuario'] = $this->request->getPost('ap_paterno');
			$usuario['ap_materno_usuario'] = $this->request->getPost('ap_materno');
			$usuario['sexo_usuario'] = $this->request->getPost('sexo');
			$usuario['email_usuario'] = $this->request->getPost('email');
			$usuario['id_rol'] = $this->request->getPost('rol');
			if($this->request->getPost('confirm_password') != ''){
				$usuario['password_usuario'] = hash('sha256', $this->request->getPost('confirm_password'));
			}//end if cambia password
			$opcion = $tabla_usuarios->existe_email_excepto_actual($usuario['email_usuario'], $id_usuario);
			if($opcion == 2 || $opcion == -100){
				if($opcion == 2){
					mensaje("El correo proporcionado ya está siendo usado por otro usuario", WARNING_ALERT, "¡Correo en uso!");
				}//end if correo en uso
				if($opcion == -100){
					mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados", WARNING_ALERT, "¡Correo en uso!");
				}//end if correo eliminado
				return $this->index($id_usuario);
			}//end if existe el email
			else{
				if(!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0){
					helper('upload_files');
					$archivo = $this->request->getFile('imagen_perfil');

					$usuario_in_db = $tabla_usuarios->select('imagen_usuario')->find($id_usuario);
					if($usuario_in_db->imagen_usuario != NULL){
						erase_file($usuario_in_db->imagen_usuario, IMG_DIR_USUARIOS);
					}//end if se debe eliminar imagen

					$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
				}//end if existe imagen
				if($tabla_usuarios->update($id_usuario, $usuario)){
					$pass = '';
					
					if ($this->request->getPost('confirm_password') != '') {
						$pass = $this->request->getPost('confirm_password');
					}//end 

					$this->enviar_editar_usuario($usuario['email_usuario'], $usuario, $pass);
					mensaje("El usuario ha sido actualizado exitosamente", SUCCESS_ALERT, "¡Actualización exitosa!");
					return redirect()->to(route_to('detalles_usuario', $id_usuario));
				}//end if actualiza el usuario
				else{
					mensaje("Hubo un error al actualizar al usuario. Intente nuevamente, por favor", DANGER_ALERT, "¡Error al actualizar!");
					return redirect()->to(route_to('detalles_usuario', $id_usuario));
				}//end else actualiza el usuario
			}//end else existe email
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end editar

}//End Class Usuario_detalles
