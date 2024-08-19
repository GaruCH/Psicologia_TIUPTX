<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Usuarios extends BaseController
{
	private $permitido = true;

	public function __construct()
	{
		$session = session();
		if (!Permisos::is_rol_permitido(TAREA_SUPERADMIN_USUARIOS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		} //end if rol no permitido
		else {
			$session->tarea_actual = TAREA_SUPERADMIN_USUARIOS;
		} //end else rol permitido
	} //end constructor

	public function index()
	{
		if ($this->permitido) {
			return $this->crear_vista("panel/usuarios", $this->cargar_datos());
		} //end if rol permitido
		else {
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
			return redirect()->to(route_to('login'));
		} //end else rol no permitido
	} //end index

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


		$datos['nombre_pagina'] = 'Administración Usuarios';

		//Breadcrumb
		$navegacion = array(
			array(
				'tarea' => 'Usuarios',
				'href' => '#'
			)
		);

		$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Usuarios');

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



	//======================================================================
	//========================SECCIÓN PARA DATATABLE========================
	//======================================================================



	public function generar_datatable_usuarios()
	{
		if ($this->permitido) {
			$session = session();
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$usuarios = $tabla_usuarios->datatable_usuarios($session->id_usuario, $session->rol_actual['clave']);
			$data = array();
			$count = 0;
			foreach ($usuarios as $usuario) {
				$sub_array = array();
				$acciones = '';
				$sub_array['total'] = ++$count;
				$sub_array['nombre_usuario'] = $usuario->nombre_usuario . ' ' . $usuario->ap_paterno_usuario . ' ' . $usuario->ap_materno_usuario;
				$sub_array['rol_usuario'] = $usuario->rol;
				$sub_array['correo_usuario'] = $usuario->email_usuario;
				if (isset($usuario->eliminacion)) {
					$acciones .= '<button type="button" class="btn btn-light-danger text-danger recover-usuario btn-circle" id="recover-usuario_' . $usuario->id_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Recuperar el usuario">
                    							<i data-feather="rotate-ccw" class="feather fill-white"></i>
                    						  </button>';
				} //end if es un psicologo eliminado
				else {
					if (($usuario->estatus_usuario) == ESTATUS_HABILITADO)
						$acciones .= '<button type="button" class="btn btn-success estatus-usuario btn-circle" id="' . $usuario->id_usuario . '_' . $usuario->estatus_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar al usuario">
                                                        <i data-feather="toggle-right" class="feather fill-white"></i>
                                                  </button>';
					else
						$acciones .= '<button type="button" class="btn btn-secondary estatus-usuario btn-circle" id="' . $usuario->id_usuario . '_' . $usuario->estatus_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar al usuario">
                                                        <i data-feather="toggle-left" class="feather fill-white"></i>
                                                  </button>';
					$acciones .= '&nbsp;&nbsp;&nbsp;';
					$acciones .=  '<button type="button" class="btn btn-warning editar-usuario btn-circle" id="editar-psicologo_' . $usuario->id_usuario . '" data-bs-toggle="tooltip" data-bs-target="#editar-usuario" data-bs-placement="top" title="Editar al usuario">
                                                    <i data-feather="edit-3" class="feather fill-white"></i>
                                              </button>';
					$acciones .= '&nbsp;&nbsp;&nbsp;';
					$acciones .=  '<button type="button" class="btn btn-info cambiar-password-usuario btn-circle" id="pass_' . $usuario->id_usuario . '" data-bs-toggle="tooltip" data-bs-target="#cambiar-password-usuario" data-bs-placement="top" title="Cambiar contraseña del usuario">
                                                    <i data-feather="unlock" class="feather feather-sm fill-white"></i><i data-feather="rotate-ccw" class="feather feather-sm fill-white" style="width: 12px; height: 12px;"></i>
                                              </button>';
					$acciones .=  '&nbsp;&nbsp;&nbsp;';
					$acciones .=  '<button type="button" class="btn btn-danger eliminar-usuario btn-circle" id="' . $usuario->id_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar al usuario">
                                                    <i data-feather="trash-2" class="feather fill-white"></i>
                                              </button>';
				} //end else es un psicologo eliminado
				$sub_array['acciones'] = $acciones;
				$data[] = $sub_array;
			} //end foreach psicologos
			return '{"data": ' . json_encode($data) . '}';
		} //end if es un usuario permitido
		else {
			return '{"data": ' . json_encode(array()) . '}';
		} //end else es un usuario permitido
	} //end generar_datatable_psicologos

	public function estatus_usuario()
	{
		if ($this->permitido) {
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			if ($tabla_usuarios->update($this->request->getPost('id'), array('estatus_usuario' => $this->request->getPost('estatus')))) {
				return $this->response->setJSON(['error' => 0]);
			} //end if se actualiza estatus
			else {
				return $this->response->setJSON(['error' => 1]);
			} //end else
		} //end if es un usuario permitido
		else {
			return $this->response->setJSON(['error' => 1]);
		} //end else es un usuario permitido
	} //end estatus

	public function eliminar_usuario()
	{
		if ($this->permitido) {
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			if ($tabla_usuarios->delete($this->request->getPost('id'))) {
				return $this->response->setJSON(['error' => 0]);
			} //end if elimina
			else {
				return $this->response->setJSON(['error' => 1]);
			} //end else
		} //end if es un usuario permitido
		else {
			return $this->response->setJSON(['error' => 1]);
		} //end else es un usuario permitido
	} //end eliminar

	public function recuperar_usuario()
	{
		if ($this->permitido && (session()->rol_actual['clave'] == ROL_SUPERADMIN['clave'])) {
			$mensaje = array();
			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			if ($tabla_usuarios->update($this->request->getPost('id'), array('eliminacion' => NULL))) {
				$mensaje['mensaje'] = 'El usuario se encuentra de nuevo en los registros de la base de datos.';
				$mensaje['tipo_mensaje'] = SUCCESS_ALERT;
				$mensaje['titulo'] = '¡Registro recuperado!';

				$acciones = array();
				$acciones[] = 'table_usuarios.ajax.reload(null,false)';

				return $this->response->setJSON(['error' => 0, 'mensaje' => $mensaje, 'actions' => $acciones]);
			} //end if se recupera el registro
			else {
				$mensaje['mensaje'] = 'Hubo un error al intentar recuperar el registro, checa tu conexión a internet o intente nuevamente, por favor.';
				$mensaje['tipo_mensaje'] = DANGER_ALERT;
				$mensaje['titulo'] = '¡Error al recuperar el registro!';

				$acciones = array();
				return $this->response->setJSON(['error' => -1, 'mensaje' => $mensaje, 'actions' => $acciones]);
			} //end else se recupera el registro
		} //end if es un usuario permitido
		else {
			return $this->response->setJSON(['error' => -1, 'mensaje' => array(), 'actions' => array()]);
		} //end else es un usuario permitido
	} //end recuperar_usuario

	public function actualizar_password_usuario()
	{
		try {
			if ($this->permitido) {
				$tabla_usuarios = new \App\Models\Tabla_usuarios();
				$id_usuario = $this->request->getPost('id_usuario_pass');


				if (empty($id_usuario)) {
					throw new \Exception('El ID del usuario es requerido.');
				}

				$usuario = [
					'actualizacion' => fecha_actual(),
					'password_usuario' => hash('sha256', $this->request->getPost('confirm_password_usuario')),
				];

				// Obtener la contraseña actual
				$actual_password_obj = $tabla_usuarios->select('password_usuario')->find($id_usuario);

				if (!$actual_password_obj) {
					throw new \Exception('El usuario con el ID especificado no existe.');
				}

				// Acceder a la contraseña actual según el formato del resultado
				if (is_array($actual_password_obj)) {
					$actual_password = $actual_password_obj['password_usuario'];
				} else {
					$actual_password = $actual_password_obj->password_usuario;
				}

				if ($usuario['password_usuario'] == $actual_password) {
					throw new \Exception('La nueva contraseña no puede ser igual a la antigua contraseña del psicólogo.');
				}

				if ($tabla_usuarios->update($id_usuario, $usuario)) {
					// Enviar correo de notificación
					$usuarioConFecha = $tabla_usuarios->find($id_usuario);

					// Convertir a array asociativo si necesario
					if (is_object($usuarioConFecha)) {
						$usuarioConFecha = [
							'nombre_usuario' => $usuarioConFecha->nombre_usuario,
							'email_usuario' => $usuarioConFecha->email_usuario,
							'fecha_cambio' => $usuarioConFecha->actualizacion
						];
					}

					if (!$this->enviarCorreoActualizacionPassword($usuarioConFecha)) {
						throw new \Exception('Error al enviar el correo de confirmación.');
					}

					$mensaje = [
						'mensaje' => 'La contraseña del usuario se ha actualizado exitosamente.',
						'titulo' => '¡Contraseña actualizada!',
						'error' => 0,
						'tipo_mensaje' => SUCCESS_ALERT,
						'timer_message' => 3500
					];
				} else {
					throw new \Exception('Hubo un error al actualizar la contraseña del usuario. Intente de nuevo, por favor.');
				}

				return $this->response->setJSON($mensaje);
			} else {
				throw new \Exception('Permiso denegado.');
			}
		} catch (\Exception $e) {
			log_message('error', 'Error en actualizar_password_usuario: ' . $e->getMessage());
			return $this->response->setJSON([
				'mensaje' => 'Error al procesar la solicitud.',
				'titulo' => '¡Error!',
				'error' => -1,
				'tipo_mensaje' => DANGER_ALERT,
				'timer_message' => 3500
			]);
		}
	} //end actualizar_password



	private function enviarCorreoActualizacionPassword($data)
	{
		$email = \Config\Services::email();

		if (empty($data['email_usuario'])) {
			log_message('error', 'Datos del usuario incompletos para enviar el correo.');
			return false;
		}

		// Registrar datos para depuración
		log_message('debug', 'Datos para la vista de correo: ' . print_r($data, true));

		// Validar que las variables dinámicas no estén vacías
		foreach ($data as $key => $value) {
			if (empty($value) && !is_array($value)) {
				log_message('error', "La variable '$key' está vacía.");
				return false;
			}
		}

		// Carga la vista y reemplaza las variables
		try {
			$message = view('plantilla/email_change_password', $data);
		} catch (\Exception $e) {
			log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
			return false;
		}

		$email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
		$email->setTo($data['email_usuario']);
		$email->setSubject('Notificación de Cambio de Contraseña');
		$email->setMessage($message);

		try {
			$email->send();
			return true;
		} catch (\Exception $e) {
			log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
			return false;
		}
	}



	//================================================================
	//===================SECCIÓN PARA CREAR===========================
	//================================================================



	public function registrar_usuario()
	{
		if ($this->permitido) {
			$mensaje = array();
			if ($this->request->getPost('sexo') == NULL) {
				$mensaje['mensaje'] = 'Debes seleccionar un sexo para el usuario';
				$mensaje['titulo'] = '¡No se pudo registrar!';
				$mensaje['error'] = 4;
				$mensaje['tipo_mensaje'] = WARNING_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			} //end if no existe sexo seleccionado

			$tabla_usuarios = new \App\Models\Tabla_usuarios();

			$usuario = [
				'estatus_usuario' => ESTATUS_HABILITADO,
				'nombre_usuario' => $this->request->getPost('nombre'),
				'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
				'ap_materno_usuario' => $this->request->getPost('ap_materno'),
				'sexo_usuario' => $this->request->getPost('sexo'),
				'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento'),
				'email_usuario' => $this->request->getPost('email'),
				'id_rol' => $this->request->getPost('rol'),
				'password_usuario' => hash('sha256', $this->request->getPost('confirm_password')),
			];

			// Verificar si el correo ya existe
			$opcion = $tabla_usuarios->existe_email($usuario['email_usuario']);

			if ($opcion == 2 || $opcion == -100) {
				if ($opcion == 2) {
					$mensaje['mensaje'] = 'El correo proporcionado ya está siendo usado por otro usuario.';
					$mensaje['titulo'] = '¡Correo en uso!';
				} elseif ($opcion == -100) {
					$mensaje['mensaje'] = 'El correo proporcionado se encuentra en el histórico de correos eliminados.';
					$mensaje['titulo'] = '¡Correo en uso!';
				}
				$mensaje['error'] = 4;
				$mensaje['tipo_mensaje'] = WARNING_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			}

			if (!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0) {
				helper('upload_files');
				$archivo = $this->request->getFile('imagen_perfil');
				$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
			} //end if existe imagen

			// Iniciar transacción
			$db = \Config\Database::connect();
			$db->transBegin();

			try {
				// Insertar en la tabla usuario
				$insertedUserId = $tabla_usuarios->insert($usuario);

				if (!$insertedUserId) {
					throw new \Exception('Error al insertar usuario.');
				}

				// Confirmar transacción
				$db->transCommit();

				// Mensaje de éxito
				$mensaje['mensaje'] = 'La cuenta ha sido registrada exitosamente.';
				$mensaje['titulo'] = '¡Registro exitoso!';
				$mensaje['error'] = 0;
				$mensaje['tipo_mensaje'] = SUCCESS_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			} catch (\Exception $e) {
				// Revertir transacción en caso de error
				$db->transRollback();

				$errorMessage = $e->getMessage();

				// Mostrar el mensaje de error (puedes ajustar cómo lo manejas)
				$mensaje['mensaje'] = 'Error al registrar la cuenta.';
				$mensaje['titulo'] = '¡Error al registrar!';
				$mensaje['error'] = -1;
				$mensaje['tipo_mensaje'] = DANGER_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			}
		} else {
			return $this->response->setJSON(['error' => -1]);
		}
	} //end registrar psicologo



	//==============================================================================
	//===================SECCIÓN PARA EDITAR========================================
	//==============================================================================



	public function obtener_datos_usuario($id_usuario = 0)
	{
		if ($this->permitido) {

			$tabla_usuarios = new \App\Models\Tabla_usuarios;
			$usuario = $tabla_usuarios->obtener_usuario($id_usuario);

			if ($usuario != NULL) {
				return $this->response->setJSON(['data' => $usuario]);
			} //end if existe usuario 
			else {
				return $this->response->setJSON(['data' => -1]);
			} //end else
		} //end if es un usuario permitido
		else {
			return $this->response->setJSON(['data' => -1]);
		} // end else es un usuario permitido
	} //end obtener_datos_usuario


	public function editar_usuario()
	{
		if ($this->permitido) {
			$mensaje = array();
			if ($this->request->getPost('sexo_editar') == NULL) {
				$mensaje['mensaje'] = 'Debes seleccionar un sexo para el usuario';
				$mensaje['titulo'] = '¡No se pudo registrar!';
				$mensaje['error'] = 4;
				$mensaje['tipo_mensaje'] = WARNING_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			}

			$tabla_usuarios = new \App\Models\Tabla_usuarios();
			$id_usuario = $this->request->getPost('id_usuario_editar');

			$usuario = [
				'nombre_usuario' => $this->request->getPost('nombre_editar'),
				'ap_paterno_usuario' => $this->request->getPost('ap_paterno_editar'),
				'ap_materno_usuario' => $this->request->getPost('ap_materno_editar'),
				'sexo_usuario' => $this->request->getPost('sexo_editar'),
				'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento_editar'),
				'email_usuario' => $this->request->getPost('email_editar'),
			];

			// Verificar si el correo ya existe
			$opcion = $tabla_usuarios->existe_email_excepto_actual($usuario['email_usuario'], $id_usuario);

			if ($opcion == 2 || $opcion == -100) {
				if ($opcion == 2) {
					$mensaje['mensaje'] = 'El correo proporcionado ya está siendo usado por otro usuario.';
					$mensaje['titulo'] = '¡Correo en uso!';
				} elseif ($opcion == -100) {
					$mensaje['mensaje'] = 'El correo proporcionado se encuentra en el histórico de correos eliminados.';
					$mensaje['titulo'] = '¡Correo en uso!';
				}
				$mensaje['error'] = 4;
				$mensaje['tipo_mensaje'] = WARNING_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			}

			if (!empty($this->request->getFile('imagen_perfil_editar')) && $this->request->getFile('imagen_perfil_editar')->getSize() > 0) {
				helper('upload_files');
				$archivo = $this->request->getFile('imagen_perfil_editar');
				$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
			}

			// Iniciar transacción
			$db = \Config\Database::connect();
			$db->transBegin();

			try {
				// Insertar en la tabla usuario
				$tabla_usuarios->update($id_usuario, $usuario);

				// Confirmar transacción
				$db->transCommit();

				// Mensaje de éxito
				$mensaje['mensaje'] = 'La cuenta ha sido actualizada exitosamente.';
				$mensaje['titulo'] = '¡Actualización exitosa!';
				$mensaje['error'] = 0;
				$mensaje['tipo_mensaje'] = SUCCESS_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			} catch (\Exception $e) {
				// Revertir transacción en caso de error
				$db->transRollback();

				$errorMessage = $e->getMessage();

				// Mensaje de error
				$mensaje['mensaje'] = 'Error al actualizar la cuenta. ' . $errorMessage;
				$mensaje['titulo'] = '¡Error al actualizar!';
				$mensaje['error'] = -1;
				$mensaje['tipo_mensaje'] = DANGER_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
			}
		} else {
			return $this->response->setJSON(['error' => -1]);
		}
	}
}//End Class Usuarios
