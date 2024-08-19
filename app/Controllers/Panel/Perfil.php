<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;
use App\Models\Tabla_usuarios;
use App\Models\Tabla_pacientes;
use App\Models\Tabla_psicologos;
use App\Models\Tabla_alumnos;
use App\Models\Tabla_programas_educativos;
use App\Models\Tabla_areas;
use App\Models\Tabla_administrativos;
use App\Models\Tabla_invitados;

class Perfil extends BaseController
{
	private $permitido = true;

	public function __construct()
	{
		$session = session();
		if (!Permisos::is_rol_permitido(TAREA_PERFIL, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		} //end if rol no permitido
		else {
			$session->tarea_actual = TAREA_PERFIL;
		} //end else rol permitido
	} //end constructor

	public function index()
	{
		if ($this->permitido) {
			return $this->crear_vista("panel/perfil", $this->cargar_datos());
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


		$datos['nombre_pagina'] = 'Mi perfil';

		//Breadcrumb
		$navegacion = array(
			array(
				'tarea' => 'Perfil',
				'href' => '#'
			)
		);

		$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Mi Perfil');

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

	public function cambiar_imagen()
	{
		if ($this->permitido) {
			$mensaje = array();
			$id_usuario = $this->request->getPost('id_usuario');

			// Verificar si se ha subido una nueva imagen
			if (!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0) {
				helper('upload_files');
				$archivo = $this->request->getFile('imagen_perfil');

				// Validar y subir la nueva imagen
				$nombre_imagen = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);

				// Actualizar el campo de imagen en el array de usuario
				$usuario['imagen_usuario'] = $nombre_imagen;
			}

			// Si no se subió una nueva imagen, no hacer cambios en el campo imagen_usuario
			if (empty($usuario['imagen_usuario'])) {
				unset($usuario['imagen_usuario']);
			}
			// Iniciar transacción
			$db = \Config\Database::connect();
			$db->transBegin();

			try {
				$tabla_usuarios = new Tabla_usuarios();

				// Actualizar solo el campo de la imagen de perfil
				if (!empty($usuario['imagen_usuario'])) {
					$tabla_usuarios->update($id_usuario, $usuario);
				}

				// Confirmar transacción
				$db->transCommit();

				// Mensaje de éxito
				$mensaje['mensaje'] = 'La imagen de perfil ha sido actualizada exitosamente.';
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
				$mensaje['mensaje'] = 'Error al actualizar la imagen de perfil. ' . $errorMessage;
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
}
