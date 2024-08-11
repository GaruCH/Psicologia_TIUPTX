<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Psicologos_paciente extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PSICOLOGO_PACIENTES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PSICOLOGO_PACIENTES;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/psicologos_paciente", $this->cargar_datos());
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



        $datos['nombre_pagina'] = 'Pacientes asignados';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Pacientes',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Pacientes');

        // Cargar notificaciones utilizando el helper
        $datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

        return $datos;
    } //end cargar_datos

    private function crear_vista($nombre_vista, $contenido = array())
    {
        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista




	//======================================================================
	//========================SECCIÓN PARA DATATABLE========================
	//======================================================================



	public function generar_datatable_psicologo_pacientes()
	{
		if ($this->permitido) {
			$session = session();
			$tabla_asignaciones = new \App\Models\Tabla_historial_asignaciones;
			$pacientes = $tabla_asignaciones->datatable_pacientes_asignados($session->id_usuario);
			$data = array();
			$count = 0;
			foreach ($pacientes as $paciente) {
				$sub_array = array();
				$acciones = '';
				$sub_array['total'] = ++$count;

               

                if ($paciente->id_subcate == SUBCATEGORIA_ALUMNO['clave']) {
                    $sub_array['identificador'] = $paciente->matricula;
                }
                elseif ($paciente->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['identificador'] =  $paciente->numero_trabajador_administrativo;
                }
                elseif ($paciente->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['identificador'] = $paciente->identificador;
                }

				$sub_array['nombre_usuario'] = $paciente->nombre_usuario . ' ' . $paciente->ap_paterno_usuario . ' ' . $paciente->ap_materno_usuario;
                
                $sub_array['edad_usuario'] = calcular_edad_persona($paciente->fecha_nacimiento_usuario);

                if ($paciente->sexo_usuario == SEXO_MASCULINO) {
                    $sub_array['sexo_usuario'] = 'Hombre';
                } else {
                    $sub_array['sexo_usuario'] = 'Mujer';
                }
				$sub_array['correo_usuario'] = $paciente->email_usuario;

                if ($paciente->id_subcate == SUBCATEGORIA_ALUMNO['clave']) {
                    $sub_array['papel_paciente'] = SUBCATEGORIA_ALUMNO['nombre'];
                }
                elseif ($paciente->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['papel_paciente'] = SUBCATEGORIA_EMPLEADO['nombre'];
                }
                elseif ($paciente->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['papel_paciente'] = SUBCATEGORIA_INVITADO['nombre'];
                }

			
					
					
					$acciones .=  '<button type="button" class="btn btn-info ver-paciente btn-circle" id="ver-paciente_' . $paciente->id_paciente . '" data-bs-toggle="tooltip" data-bs-target="#ver-paciente" data-bs-placement="top" title="Ver información">
                                                    <i data-feather="search" class="feather fill-white"></i>
                                              </button>';
					$acciones .= '&nbsp;&nbsp;&nbsp;';
					
				
				$sub_array['acciones'] = $acciones;
				$data[] = $sub_array;
			} //end foreach psicologos
			return '{"data": ' . json_encode($data) . '}';
		} //end if es un usuario permitido
		else {
			return '{"data": ' . json_encode(array()) . '}';
		} //end else es un usuario permitido
	} //end generar_datatable_psicologos

    


    //==============================================================================
    //===================SECCIÓN PARA CONSULTAR========================================
    //==============================================================================



    
    public function obtener_datos_paciente($id_paciente = 0)
    {
        if ($this->permitido) {

            $tabla_asignaciones = new \App\Models\Tabla_historial_asignaciones;
            $paciente = $tabla_asignaciones->obtener_paciente_asignado($id_paciente);

            if ($paciente != NULL) {
                return $this->response->setJSON(['data' => $paciente]);
            } //end if existe psicólogo 
            else {
                return $this->response->setJSON(['data' => -1]);
            } //end else
        } //end if es un usuario permitido
        else {
            return $this->response->setJSON(['data' => -1]);
        } // end else es un usuario permitido
    } //end obtener_datos_psicologo

} 