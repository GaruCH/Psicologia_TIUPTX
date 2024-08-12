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

    public function index()
    {
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
        $psicologos = $tabla_usuarios->obtener_psicologos_activos();

        // Transformar el resultado en un array adecuado para form_dropdown
        $psicologos_opciones = ['' => 'Seleccione un psicólogo...'];
        foreach ($psicologos as $psicologo) {
            $psicologos_opciones[$psicologo->id_usuario . '|' . $psicologo->numero_trabajador_psicologo] = $psicologo->nombre_usuario . ' ' . $psicologo->ap_paterno_usuario . ' ' . $psicologo->ap_materno_usuario;
        }



        // Pasar las subcategorías a la vista
        $contenido['psicologos'] = $psicologos_opciones; // Aquí pasamos 'dias' al contenido

        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista


    public function generar_datatable_asignaciones()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_asignaciones = new \App\Models\Tabla_asignaciones;
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
                } elseif ($asignacion->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['identificador_paciente'] =  $asignacion->numero_trabajador_administrativo;
                } elseif ($asignacion->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['identificador_paciente'] = $asignacion->identificador;
                }

                $sub_array['nombre_paciente'] = $asignacion->nombre_paciente . ' ' . $asignacion->ap_paterno_paciente . ' ' . $asignacion->ap_materno_paciente;

                $sub_array['fecha_asignacion'] = $asignacion->fecha_asignacion;

                $acciones .=  '<button type="button" class="btn btn-warning editar-asignacion btn-circle" id="editar-asignacion_' . $asignacion->id_asignacion . '" data-bs-toggle="tooltip" data-bs-target="#editar-asignacion" data-bs-placement="top" title="Editar asignacion">
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


    public function obtener_datos_asignacion($id_asignacion = 0)
    {
        if ($this->permitido) {

            $tabla_asignaciones = new \App\Models\Tabla_asignaciones;
            $asignacion = $tabla_asignaciones->obtener_asignacion($id_asignacion);

            if ($asignacion != NULL) {
                return $this->response->setJSON(['data' => $asignacion]);
            } //end if existe psicólogo 
            else {
                return $this->response->setJSON(['data' => -1]);
            } //end else
        } //end if es un usuario permitido
        else {
            return $this->response->setJSON(['data' => -1]);
        } // end else es un usuario permitido
    } //end obtener_datos_psicologo

    public function actualizar_asignacion()
    {
        if ($this->permitido) {
            $mensaje = array();
            $id_asignacion = $this->request->getPost('id_asignacion');
            $nuevo_psicologo_id = $this->request->getPost('psicologo');
            $id_paciente = $this->request->getPost('id_paciente');

            // Verificar que el id_asignacion y nuevo_psicologo_id estén presentes
            if (!$id_asignacion || !$nuevo_psicologo_id || !$id_paciente) {
                $mensaje['mensaje'] = 'Faltan datos necesarios para realizar la actualización.';
                $mensaje['titulo'] = '¡Error en la solicitud!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }

            $tabla_asignacion = new \App\Models\Tabla_asignaciones;
            $tabla_historial = new \App\Models\Tabla_historial_asignaciones;

            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Obtener la asignación original para verificar el psicólogo
                $asignacion_original = $tabla_asignacion->find($id_asignacion);

                if (!$asignacion_original) {
                    throw new \Exception('No se encontró la asignación original.');
                }

                // Verificar si el nuevo psicólogo es el mismo que el original
                if ((int)$asignacion_original->id_psicologo === (int)$nuevo_psicologo_id) {
                    $mensaje['mensaje'] = 'El psicólogo asignado es el mismo. No se realizaron cambios.';
                    $mensaje['titulo'] = '¡Sin cambios!';
                    $mensaje['error'] = 0;
                    $mensaje['tipo_mensaje'] = INFO_ALERT;
                    $mensaje['timer_message'] = 3500;
                    return $this->response->setJSON($mensaje);
                }

                // 1. Crear un registro en el historial para la asignación original
                $historial_data_original = [
                    'id_asignacion' => $id_asignacion,
                    'id_psicologo' => $asignacion_original->id_psicologo,
                    'id_paciente' => $id_paciente,
                    'estatus_asignacion' => -1,
                    'fecha_historial' => date('Y-m-d H:i:s'),
                    'descripcion' => 'Asignación cambiada desde el sistema.',
                ];

                $tabla_historial->insert($historial_data_original);

                $tabla_pacientes = new \App\Models\Tabla_pacientes();
                $paciente = $tabla_pacientes->obtener_paciente($id_paciente);

                $notificacionOriginalData = [
                    'id_usuario' => $asignacion_original->id_psicologo,
                    'titulo_notificacion' => 'Paciente Desasignado',
                    'tipo_notificacion' => 'warning',
                    'mensaje' => 'Se te ha desasignado un paciente: ' .
                        $paciente->nombre_usuario . ' ' .
                        $paciente->ap_paterno_usuario . ' ' .
                        $paciente->ap_materno_usuario,
                    'leida' => 0
                ];

                // Llamar a la función para crear la notificación
                crear_notificacion($notificacionOriginalData);

                // 2. Actualizar la asignación original con el nuevo psicólogo
                $nueva_asignacion_data = [
                    'id_psicologo' => $nuevo_psicologo_id,
                ];

                $tabla_asignacion->update($id_asignacion, $nueva_asignacion_data);

                // 1. Crear un registro en el historial para la nueva asignación 
                $historial_data_nuevo = [
                    'id_asignacion' => $id_asignacion,
                    'id_psicologo' => $nuevo_psicologo_id,
                    'id_paciente' => $id_paciente,
                    'estatus_asignacion' => 1,
                    'fecha_historial' => date('Y-m-d H:i:s'),
                    'descripcion' => 'Asignación cambiada desde el sistema.',
                ];

                $tabla_historial->insert($historial_data_nuevo);

                // Crear notificación para el psicólogo asignado
                // Datos de la notificación
                $notificacionData = [
                    'id_usuario' => $nuevo_psicologo_id,
                    'titulo_notificacion' => 'Nuevo Paciente Asignado', // Título de la notificación
                    'tipo_notificacion' => 'info', // Tipo de notificación
                    'mensaje' => 'Se te ha asignado un nuevo paciente: ' .
                        $paciente->nombre_usuario . ' ' .
                        $paciente->ap_paterno_usuario . ' ' .
                        $paciente->ap_materno_usuario,
                    'leida' => 0 // 0 indica que la notificación no ha sido leída
                ];

                // Llamar a la función para crear la notificación
                crear_notificacion($notificacionData);


                // Confirmar transacción
                $db->transCommit();

                // Mensaje de éxito
                $mensaje['mensaje'] = 'La asignación ha sido actualizada exitosamente.';
                $mensaje['titulo'] = '¡Actualización exitosa!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $db->transRollback();

                $errorMessage = $e->getMessage();

                // Mostrar el mensaje de error
                $mensaje['mensaje'] = 'Error al actualizar la asignación.';
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
