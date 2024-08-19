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

        $session = session();

        $perfil = cargarPerfilUsuario($session);

        // Combinar el contenido existente con el perfil de usuario
        $contenido = array_merge($contenido, $perfil);

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
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Obtener la asignación original
                $asignacion_original = $tabla_asignacion->find($id_asignacion);

                if (!$asignacion_original) {
                    throw new \Exception('No se encontró la asignación original.');
                }

                // Verificar si el nuevo psicólogo es el mismo que el original
                if ((int)$asignacion_original->id_psicologo === (int)$nuevo_psicologo_id) {
                    $mensaje['mensaje'] = 'La asignación ya está activa con el psicólogo actual.';
                    $mensaje['titulo'] = '¡Sin cambios!';
                    $mensaje['error'] = 0;
                    $mensaje['tipo_mensaje'] = INFO_ALERT;
                    $mensaje['timer_message'] = 3500;
                    $db->transCommit(); // Confirmar transacción aquí
                    return $this->response->setJSON($mensaje);
                }

                // Verificar si ya existe una asignación con el paciente y el nuevo psicólogo
                $asignacion_existente = $tabla_asignacion->where('id_paciente', $id_paciente)
                    ->where('id_psicologo', $nuevo_psicologo_id)
                    ->first();

                if ($asignacion_existente) {
                    // Si existe, solo actualizar el campo de estatus
                    $tabla_asignacion->update($asignacion_existente->id_asignacion, [
                        'estatus_asignacion' => ESTATUS_ACTIVA
                    ]);

                    // Después de activar la asignación existente
                    $historial_data_existente = [
                        'id_asignacion' => $asignacion_existente->id_asignacion,
                        'estatus_anterior' => ESTATUS_INACTIVA,
                        'nuevo_estatus' => ESTATUS_ACTIVA,
                        'fecha_historial' => date('Y-m-d H:i:s'),
                        'descripcion' => 'Asignación existente activada durante la actualización.',
                    ];
                    $tabla_historial->insert($historial_data_existente);

                    // Después de activar la asignación existente
                    $notificacionData = [
                        'id_usuario' => $asignacion_existente->id_psicologo,
                        'titulo_notificacion' => 'Asignación Activada',
                        'tipo_notificacion' => 'info',
                        'mensaje' => 'Se ha activado una de tus asignaciones.',
                        'leida' => 0
                    ];
                    crear_notificacion($notificacionData);

                    // Desactivar la asignación original
                    $tabla_asignacion->update($id_asignacion, [
                        'estatus_asignacion' => ESTATUS_INACTIVA
                    ]);

                    // Después de desactivar la asignación original
                    $historial_data_original = [
                        'id_asignacion' => $id_asignacion,
                        'estatus_anterior' => ESTATUS_ACTIVA,
                        'nuevo_estatus' => ESTATUS_INACTIVA,
                        'fecha_historial' => date('Y-m-d H:i:s'),
                        'descripcion' => 'Asignación desactivada durante la actualización.',
                    ];
                    $tabla_historial->insert($historial_data_original);

                    // Después de desactivar la asignación original
                    $notificacionData = [
                        'id_usuario' => $asignacion_original->id_psicologo,
                        'titulo_notificacion' => 'Asignación Desactivada',
                        'tipo_notificacion' => 'warning',
                        'mensaje' => 'Se ha desactivado una de tus asignaciones.',
                        'leida' => 0
                    ];
                    crear_notificacion($notificacionData);
                } else {
                    // Si no existe, insertar una nueva asignación con el nuevo psicólogo
                    $nueva_asignacion_data = [
                        'id_paciente' => $id_paciente,
                        'id_psicologo' => $nuevo_psicologo_id,
                        'descripcion' => 'Nueva asignación creada desde el sistema.',
                        'estatus_asignacion' => ESTATUS_ACTIVA,
                    ];
                    $asignacionId = $tabla_asignacion->insert($nueva_asignacion_data);

                    // Después de insertar una nueva asignación
                    $historial_data_nueva = [
                        'id_asignacion' => $asignacionId,
                        'estatus_anterior' => NULL,
                        'nuevo_estatus' => ESTATUS_ACTIVA,
                        'fecha_historial' => date('Y-m-d H:i:s'),
                        'descripcion' => 'Nueva asignación creada durante la actualización.',
                    ];
                    $tabla_historial->insert($historial_data_nueva);

                    // Después de insertar una nueva asignación
                    $notificacionData = [
                        'id_usuario' => $nuevo_psicologo_id,
                        'titulo_notificacion' => 'Nueva Asignación',
                        'tipo_notificacion' => 'info',
                        'mensaje' => 'Tienes una nueva asignación.',
                        'leida' => 0
                    ];
                    crear_notificacion($notificacionData);

                    // Desactivar la asignación original
                    $tabla_asignacion->update($id_asignacion, [
                        'estatus_asignacion' => ESTATUS_INACTIVA
                    ]);

                    // Después de desactivar la asignación original
                    $historial_data_original = [
                        'id_asignacion' => $id_asignacion,
                        'estatus_anterior' => ESTATUS_ACTIVA,
                        'nuevo_estatus' => ESTATUS_INACTIVA,
                        'fecha_historial' => date('Y-m-d H:i:s'),
                        'descripcion' => 'Asignación desactivada durante la actualización.',
                    ];
                    $tabla_historial->insert($historial_data_original);

                    // Después de desactivar la asignación original
                    $notificacionData = [
                        'id_usuario' => $asignacion_original->id_psicologo,
                        'titulo_notificacion' => 'Asignación Desactivada',
                        'tipo_notificacion' => 'warning',
                        'mensaje' => 'Se ha desactivado una de tus asignaciones.',
                        'leida' => 0
                    ];
                    crear_notificacion($notificacionData);
                }

                $db->transCommit(); // Confirmar transacción aquí

                $mensaje['mensaje'] = 'La asignación ha sido actualizada exitosamente.';
                $mensaje['titulo'] = '¡Actualización exitosa!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                $db->transRollback();

                $mensaje['mensaje'] = 'Error al actualizar la asignación: ' . $e->getMessage();
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
