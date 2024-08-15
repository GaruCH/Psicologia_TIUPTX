<?php

namespace App\Controllers\Panel;


use CodeIgniter\I18n\Time;
use App\Libraries\Permisos;
use App\Models\Tabla_citas;
use App\Controllers\BaseController;


class Historial_paciente_citas extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PACIENTE_CITAS_HISTORIAL, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PACIENTE_CITAS_HISTORIAL;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/pacientes_historial_citas", $this->cargar_datos());
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



        $datos['nombre_pagina'] = 'Historial Citas';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Historial Citas',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Historial de Citas');

        // Cargar notificaciones utilizando el helper
        $datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

        return $datos;
    } //end cargar_datos

    private function crear_vista($nombre_vista, $contenido = array())
    {
        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista

    public function generar_datatable_historial_citas()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_citas = new Tabla_citas();
            $citas = $tabla_citas->datatable_historial_citas_paciente($session->id_usuario);
            $data = array();
            $count = 0;
            foreach ($citas as $cita) {
                $sub_array = array();
                $imgestadoP = '';
                $imgestadoA = '';
                $imgestadoC = '';
                $imgestadoB = '';
                $imgestadoP .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Pendiente-Sistema_UPTX.svg') . '" alt="Cita pendiente">';
                $imgestadoA .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Aceptado-Sistema_UPTX.svg') . '" alt="Cita aceptada">';
                $imgestadoC .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Cancelado-Sistema_UPTX.svg') . '" alt="Cita cancelada">';
                $imgestadoB .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Cancelado-Sistema_UPTX.svg') . '" alt="Cita cancelada">';
                $sub_array['total'] = ++$count;

                $sub_array['nombre_psicologo'] = $cita->nombre_psicologo . ' ' . $cita->ap_paterno_psicologo . ' ' . $cita->ap_materno_psicologo;

                $sub_array['descripcion_cita'] = $cita->descripcion;

                $sub_array['fecha_cita'] = $cita->fecha_historial;

                if ($cita->nuevo_estatus == ESTATUS_PENDIENTE) {
                    $sub_array['estado_cita'] = $imgestadoP;
                } elseif ($cita->nuevo_estatus == ESTATUS_CONFIRMADA) {
                    $sub_array['estado_cita'] = $imgestadoA;
                } elseif ($cita->nuevo_estatus == ESTATUS_CANCELADA) {
                    $sub_array['estado_cita'] = $imgestadoC;
                } elseif ($cita->nuevo_estatus == ESTATUS_CONCLUIDA) {
                    $sub_array['estado_cita'] = $imgestadoB;
                }
                $data[] = $sub_array;
            } //end foreach psicologos
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_psicologos
}