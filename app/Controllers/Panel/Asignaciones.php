<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Asignaciones extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_ADMIN_ASIGNACIONES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_ADMIN_ASIGNACIONES;
        } //end else rol permitido
    } //end constructor

    public function index() {
        if ($this->permitido) {
            return $this->crear_vista("panel/asignaciones", $this->cargar_datos());
        } //end if rol permitido
        else {
            mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
            return redirect()->to(route_to('login'));
        } //end else rol no permitido
    }
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



        $datos['nombre_pagina'] = 'Asignaciones';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Asignaciones',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Asignaciones');

        // Cargar notificaciones utilizando el helper
        $datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

        return $datos;
    } //end cargar_datos

    private function crear_vista($nombre_vista, $contenido = array())
    {
        
        //Cargar el modelo de usuarios
        $tabla_usuarios = new \App\Models\Tabla_usuarios;
        $psicologos = $tabla_usuarios->obtener_psico;

        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista


    public function generar_datatable_asignaciones()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_asignaciones = new \App\Models\Tabla_historial_asignaciones;
            $asignaciones = $tabla_asignaciones->datatable_asignaciones($session->rol_actual['clave']);
            $data = array();
            $count = 0;
            foreach ($asignaciones as $asignacion) {
                $sub_array = array();
                $acciones = '';
                $sub_array['total'] = ++$count;

                $sub_array['numero_trabajador'] = $asignacion->numero_trabajador_psicologo;

                $sub_array['nombre_psicologo'] = $asignacion->nombre_psicologo . ' ' . $asignacion->ap_paterno_psicologo . ' ' . $asignacion->ap_materno_psicologo;
                
                if ($asignacion->id_subcate == SUBCATEGORIA_ALUMNO['clave']) {
                    $sub_array['identificador_paciente'] = $asignacion->matricula;
                }
                elseif ($asignacion->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['identificador_paciente'] =  $asignacion->numero_trabajador_administrativo;
                }
                elseif ($asignacion->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['identificador_paciente'] = $asignacion->identificador;
                }

                $sub_array['nombre_paciente'] = $asignacion->nombre_paciente . ' ' . $asignacion->ap_paterno_paciente . ' ' . $asignacion->ap_materno_paciente;

                $sub_array['fecha_asignacion'] = $asignacion->fecha_asignacion;

                $acciones .=  '<button type="button" class="btn btn-warning editar-asignacion btn-circle" id="editar-asignacion_' . $asignacion->id_historial . '" data-bs-toggle="tooltip" data-bs-target="#editar-asignacion" data-bs-placement="top" title="Editar asignacion">
                                                    <i data-feather="edit-3" class="feather fill-white"></i>
                                              </button>';
					$acciones .= '&nbsp;&nbsp;&nbsp;';
					
				
				$sub_array['acciones'] = $acciones;

                $data[] = $sub_array;
            } //end foreach horarios
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_horarios

}