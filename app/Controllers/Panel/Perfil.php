<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;
use App\Models\Tabla_usuarios;
use App\Models\Tabla_pacientes;
use App\Models\Tabla_psicologos;
use App\Models\Tabla_alumnos;
use App\Models\Tabla_programas_educativos;

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
			return $this->crear_vista("panel/perfil_superadmin", $this->cargar_datos());
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
		$tabla_usuarios = new Tabla_usuarios();
		$tabla_pacientes = new Tabla_pacientes();
		$tabla_psicologo = new Tabla_psicologos();
		$tabla_alumnos = new Tabla_alumnos();
		$tabla_programas = new Tabla_programas_educativos();
		$usuario = $tabla_usuarios->obtener_usuario($session->id_usuario);
		$contenido['nombre'] = $usuario->nombre_usuario;
		$contenido['ap_paterno'] = $usuario->ap_paterno_usuario;
		$contenido['ap_materno'] = $usuario->ap_materno_usuario;
		$contenido['sexo'] = $usuario->sexo_usuario;
		$contenido['email'] = $usuario->email_usuario;
		$contenido['rol'] = $session->rol_actual['clave'];
		$contenido['imagen'] = $usuario->imagen_usuario;
		if ($session->rol_actual['clave'] == ROL_PSICOLOGO['clave']) {
			$psicologo = $tabla_psicologo->obtener_psicologo($session->id_usuario);
			$contenido['numero_trabajador_psicologo'] = $psicologo->numero_trabajador_psicologo;
		} elseif ($session->rol_actual['clave'] == ROL_PACIENTE['clave']) {
			$paciente = $tabla_pacientes->obtener_paciente($session->id_usuario);
			$contenido['expediente'] = $paciente->numero_expediente;
			$contenido['tipo_paciente'] = $paciente->id_subcate;		
					switch ($paciente->id_tipo_referencia) {
						case TIPO_REFERENCIA_OTRO['clave']:
							$contenido['referencia'] = 'Otro';
							break;
							case TIPO_REFERENCIA_SERVICIO_MEDICO['clave']:
								$contenido['referencia'] = 'Servicio Médico';
								break;
								case TIPO_REFERENCIA_DIRECTOR_CARRERA['clave']:
									$contenido['referencia'] = 'Director de Carrera';
									break;
									case TIPO_REFERENCIA_TUTOR['clave']:
										$contenido['referencia'] = 'Tutor';
										break;
						default:
							# code...
							break;
					}

					switch ($paciente->id_tipo_atencion) {
						case TIPO_ATENCION_PRIMERA_VEZ['clave']:
							$contenido['atencion'] = 'Primera Vez';
							break;

							case TIPO_ATENCION_SUBSUCUENTE['clave']:
								$contenido['atencion'] = 'Subsecuente';
								break;
						
						default:
							# code...
							break;
					}


			switch ($paciente->id_subcate) {
				case SUBCATEGORIA_ALUMNO['clave']:
					$alumno = $tabla_alumnos->obtener_alumno($session->id_usuario);
					$programa = $tabla_programas->obtener_programa_educativo($alumno->id_programa);
					

					$contenido['matricula'] = $alumno->matricula;
					$contenido['carrera'] = $programa->nombre_programa;

					break;
				case SUBCATEGORIA_EMPLEADO['clave']:
					# code...
					break;

				case SUBCATEGORIA_INVITADO['clave']:
					# code...
					break;
				default:
					# code...
					break;
			}
		}

		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	} //end crear_vista

}
