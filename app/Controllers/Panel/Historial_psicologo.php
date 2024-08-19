<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Historial_psicologo extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PSICOLOGO_HISTORIAL_PACIENTES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PSICOLOGO_HISTORIAL_PACIENTES;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/historial_psicologo", $this->cargar_datos());
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



        $datos['nombre_pagina'] = 'Historial de Pacientes';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Historial Pacientes',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Historial Pacientes');

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



    public function generar_datatable_historial_pacientes()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_asignaciones = new \App\Models\Tabla_asignaciones;
            $pacientes = $tabla_asignaciones->datatable_historial_pacientes($session->id_usuario);
            $data = array();
            $count = 0;
            foreach ($pacientes as $paciente) {
                $sub_array = array();
                $sub_array['total'] = ++$count;

                if ($paciente->id_subcate == SUBCATEGORIA_ALUMNO['clave']) {
                    $sub_array['identificador'] = $paciente->matricula;
                } elseif ($paciente->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['identificador'] =  $paciente->numero_trabajador_administrativo;
                } elseif ($paciente->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['identificador'] = $paciente->identificador;
                }

                $sub_array['nombre_usuario'] = $paciente->nombre_paciente . ' ' . $paciente->ap_paterno_paciente . ' ' . $paciente->ap_materno_paciente;

                if ($paciente->nuevo_estatus == ESTATUS_ACTIVA) {
                    $sub_array['estado_asignacion'] = 'ACTIVA';
                }
                else{
                    $sub_array['estado_asignacion'] = 'INACTIVA';
                }

                

                $sub_array['fecha_historial'] = $paciente->fecha_historial;

                $sub_array['descripcion_historial'] = $paciente->descripcion;

                $data[] = $sub_array;
            } //end foreach psicologos
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_psicologos


}
