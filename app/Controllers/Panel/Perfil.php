<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Perfil extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_PERFIL, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_PERFIL;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/perfil", $this->cargar_datos());
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
		$datos['nombre_pagina'] = 'Mi Perfil';
		//Cargar Modelos
		$tabla_usuarios = new \App\Models\Tabla_usuarios;
		$datos['usuario'] = $tabla_usuarios->obtener_usuario($session->id_usuario);

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Mi Perfil',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Mi Perfil: <b>'.$session->nombre_completo_usuario.'</b>');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista,$contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	public function actualizar(){
		if($this->permitido){
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$id_usuario = session()->id_usuario;
			$usuario = array();
			$usuario['nombre_usuario'] = $this->request->getPost('nombre');
			$usuario['ap_paterno_usuario'] = $this->request->getPost('ap_paterno');
			$usuario['ap_materno_usuario'] = $this->request->getPost('ap_materno');
			$usuario['sexo_usuario'] = $this->request->getPost('sexo');
			$usuario['email_usuario'] = $this->request->getPost('email');

			$flag_cambio_correo = ($usuario['email_usuario'] == ($tabla_usuarios->select('email_usuario')->find($id_usuario))->email_usuario) ? FALSE : TRUE;
			$opcion = $tabla_usuarios->existe_email_excepto_actual($usuario['email_usuario'], $id_usuario);
			if($opcion == 2 || $opcion == -100){
				if($opcion == 2){
					mensaje("El correo proporcionado ya está siendo usado por otro usuario", WARNING_ALERT, "¡Correo En Uso!");
				}//end if correo en uso
				if($opcion == -100){
					mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados", WARNING_ALERT, "¡Correo En Uso!");
				}//end if correo eliminado
				return $this->index();
			}//end if existe el email
			else{
				$usuario_in_db = $tabla_usuarios->select('imagen_usuario')->find($id_usuario);
				if(!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0){
					helper('upload_files');
					$archivo = $this->request->getFile('imagen_perfil');

					if($usuario_in_db->imagen_usuario != NULL){
						erase_file($usuario_in_db->imagen_usuario, IMG_DIR_USUARIOS);
					}//end if se debe eliminar imagen

					$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
				}//end if existe imagen
				if($tabla_usuarios->update($id_usuario, $usuario)){
					if($flag_cambio_correo){
						$nombre_usuario = array();
						$nombre_usuario['imagen_usuario'] = (isset($usuario['imagen_usuario']) ? $usuario['imagen_usuario'] :
														    ($usuario_in_db->imagen_usuario == NULL ? ($usuario['sexo_usuario'] == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png')
																									: $usuario_in_db->imagen_usuario));
						$nombre_usuario['nombre'] = $usuario['nombre_usuario'].' '.
													$usuario['ap_paterno_usuario'].' '.
													$usuario['ap_materno_usuario'];
						session()->destroy();
						return view('usuario/cambio_correo', $nombre_usuario);
					}//end if cambia correo
					$session = session();
					$session->nombre_usuario = $usuario['nombre_usuario'];
					$session->nombre_completo_usuario = $usuario['nombre_usuario'].' '.
														$usuario['ap_paterno_usuario'].' '.
														$usuario['ap_materno_usuario'];
					$session->sexo_usuario = $usuario['sexo_usuario'];
					$session->email_usuario = $usuario['email_usuario'];
					if(isset($usuario['imagen_usuario'])){
						$session->imagen_usuario = $usuario['imagen_usuario'];
					}//end if se cambia la foto de perfil
					$session = null;
					mensaje("Tus datos han sido actualizados exitosamente", SUCCESS_ALERT, "¡Actualización Del Perfil Exitosa!");
					return redirect()->to(route_to('mi_perfil'));
				}//end if se actualiza el perfil
				else{
					mensaje("Hubo un error al actualizar tu perfil. Intente nuevamente, por favor", DANGER_ALERT, "¡Error Al Actualizar Perfil!");
					return redirect()->to(route_to('mi_perfil'));
				}//end else se actualiza el perfil
			}//end if no existe el email
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end actualizar

}//end Class Perfil
