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

	public function actualizar()
	{
		try {
			if ($this->permitido) {
				$tabla_usuarios = new \App\Models\Tabla_usuarios();
				$id_usuario = $this->request->getPost('id_usuario_pass_panel');

				$usuario = [
					'actualizacion' => fecha_actual(),
					'password_usuario' => hash('sha256', $this->request->getPost('confirm_password_usuario_panel')),
				];

				// Obtener la contraseña actual
				$actual_password_obj = $tabla_usuarios->select('password_usuario')->find($id_usuario);

				// Acceder a la contraseña actual según el formato del resultado
				if (is_array($actual_password_obj)) {
					$actual_password = $actual_password_obj['password_usuario'];
				} else {
					$actual_password = $actual_password_obj->password_usuario;
				}

				if ($usuario['password_usuario'] == $actual_password) {
				$mensaje['mensaje'] = 'La nueva contraseña no puede ser igual a la antigua contraseña.';
				$mensaje['titulo'] = '¡Error al actualizar la contraseña!';
				$mensaje['error'] = 4;
				$mensaje['tipo_mensaje'] = WARNING_ALERT;
				$mensaje['timer_message'] = 3500;
				return $this->response->setJSON($mensaje);
				}

				if ($tabla_usuarios->update($id_usuario, $usuario)) {
					// Enviar correo de notificación
					$usuarioConFecha = $tabla_usuarios->find($id_usuario);

					if (!$this->enviarCorreoActualizacionPassword($usuarioConFecha)) {
						throw new \Exception('Error al enviar el correo de confirmación.');
					}

					// Convertir a array asociativo si necesario
					if (is_object($usuarioConFecha)) {
						$usuarioConFecha = [
							'nombre_usuario' => $usuarioConFecha->nombre_usuario,
							'email_usuario' => $usuarioConFecha->email_usuario,
							'fecha_cambio' => $usuarioConFecha->actualizacion
						];
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

}//End Class Password
