<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Horarios extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PSICOLOGO_HORARIOS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PSICOLOGO_HORARIOS;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/horarios_psicologos", $this->cargar_datos());
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



        $datos['nombre_pagina'] = 'Administración Horario';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Horario',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Administrar Horario');

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

        // Cargar el modelo de subcategorías
        $tabla_dias = new \App\Models\Tabla_dias;
        $dias = $tabla_dias->obtener_dias();

        // Transformar el resultado en un array adecuado para form_dropdown
        $dias_opciones = ['' => 'Seleccione un día...'];
        foreach ($dias as $clave => $nombre) {
            $dias_opciones[$clave] = $nombre;
        }

        // Pasar las subcategorías a la vista
        $contenido['dias'] = $dias_opciones; // Aquí pasamos 'dias' al contenido

        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista




    //======================================================================
    //========================SECCIÓN PARA DATATABLE========================
    //======================================================================



    public function generar_datatable_horario()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_horarios = new \App\Models\Tabla_horarios;
            $horarios = $tabla_horarios->datatable_horarios($session->id_usuario, $session->rol_actual['clave']);
            $data = array();
            foreach ($horarios as $horario) {
                $sub_array = array();
                $acciones = '';
                $sub_array['id_h'] = $horario->id_horario;
                if ($horario->id_dia == DIA_LUNES['clave']) {
                    $sub_array['dia'] = DIA_LUNES['nombre'];
                } elseif ($horario->id_dia == DIA_MARTES['clave']) {
                    $sub_array['dia'] = DIA_MARTES['nombre'];
                } elseif ($horario->id_dia == DIA_MIERCOLES['clave']) {
                    $sub_array['dia'] = DIA_MIERCOLES['nombre'];
                } elseif ($horario->id_dia == DIA_JUEVES['clave']) {
                    $sub_array['dia'] = DIA_JUEVES['nombre'];
                } elseif ($horario->id_dia == DIA_VIERNES['clave']) {
                    $sub_array['dia'] = DIA_VIERNES['nombre'];
                } elseif ($horario->id_dia == DIA_SABADO['clave']) {
                    $sub_array['dia'] = DIA_SABADO['nombre'];
                }

                if (($horario->estatus_horario) == ESTATUS_HABILITADO) {
                    $acciones .= '<button type="button" class="btn btn-success estatus-horario btn-circle" id="' . $horario->id_horario . '_' . $horario->estatus_horario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar horario">
                                                    <i data-feather="toggle-right" class="feather fill-white"></i>
                                              </button>';
                } else {
                    $acciones .= '<button type="button" class="btn btn-secondary estatus-horario btn-circle" id="' . $horario->id_horario . '_' . $horario->estatus_horario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar horario">
                                                    <i data-feather="toggle-left" class="feather fill-white"></i>
                                              </button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                }

                $sub_array['hora_entrada'] = $horario->turno_entrada;
                $sub_array['hora_salida'] = $horario->turno_salida;
                $sub_array['estado'] = $acciones;
                $data[] = $sub_array;
            } //end foreach horarios
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_horarios

    public function estatus_horario()
    {
        if ($this->permitido) {
            $tabla_horarios = new \App\Models\Tabla_horarios;
            if ($tabla_horarios->update($this->request->getPost('id'), array('estatus_horario' => $this->request->getPost('estatus')))) {
                return $this->response->setJSON(['error' => 0]);
            } //end if se actualiza estatus
            else {

                return $this->response->setJSON(['error' => 1]);
            } //end else
        } //end if es un psicologo permitido
        else {
            return $this->response->setJSON(['error' => 1]);
        } //end else es un psicologo permitido
    } //end estatus



    //================================================================
    //===================SECCIÓN PARA CREAR===========================
    //================================================================


    public function registrar_horario()
    {
        if ($this->permitido) {
            $mensaje = array();

            // Validar si se seleccionó el día
            if ($this->request->getPost('dia') == NULL) {
                $mensaje['mensaje'] = 'Debes seleccionar un día.';
                $mensaje['titulo'] = '¡No se pudo registrar!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } //end if no existe día seleccionado

            // Validar si se ingresó la hora de entrada y salida
            if ($this->request->getPost('hora_entrada') == NULL || $this->request->getPost('hora_salida') == NULL) {
                $mensaje['mensaje'] = 'Debes ingresar la hora de entrada y salida.';
                $mensaje['titulo'] = '¡No se pudo registrar!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } //end if no existe hora de entrada o salida


            $tabla_horarios = new \App\Models\Tabla_horarios();
            $sesion = session();
            $horario = [
                'id_dia' => $this->request->getPost('dia'),
                'turno_entrada' => $this->request->getPost('hora_entrada'),
                'turno_salida' => $this->request->getPost('hora_salida'),
                'estatus_horario' => ESTATUS_HABILITADO, 
                'id_psicologo' => $sesion->id_usuario 
            ];

            if ($tabla_horarios->horarioExists($horario['id_psicologo'], $horario['id_dia'])) {
                $mensaje['mensaje'] = 'Ya existe un horario registrado para el mismo día.';
                $mensaje['titulo'] = '¡Horario en conflicto!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }

            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Insertar en la tabla horario
                $insertedHorarioId = $tabla_horarios->insert($horario);

                if (!$insertedHorarioId) {
                    throw new \Exception('Error al insertar horario.');
                }

                // Confirmar transacción
                $db->transCommit();

                // Mensaje de éxito
                $mensaje['mensaje'] = 'El horario ha sido registrado exitosamente.';
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
                $mensaje['mensaje'] = 'Error al registrar el horario.';
                $mensaje['titulo'] = '¡Error al registrar!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
        } else {
            return $this->response->setJSON(['error' => -1]);
        }
    } //end registrar_horario




    //==============================================================================
    //===================SECCIÓN PARA EDITAR========================================
    //==============================================================================


    public function actualizar_horas()
    {
        if ($this->permitido) {
            $request = \Config\Services::request();
            $datos_actualizacion = $request->getJSON();
    
            // Inicializar el mensaje de respuesta
            $mensaje = array();
    
            // Validar los datos recibidos
            if (empty($datos_actualizacion->updates)) {
                $mensaje['mensaje'] = 'No se recibieron datos para actualizar.';
                $mensaje['titulo'] = '¡Error!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
    
            $tabla_horarios = new \App\Models\Tabla_horarios();
            $db = \Config\Database::connect();
            $db->transBegin();
    
            try {
                $actualizaciones_realizadas = false;
    
                foreach ($datos_actualizacion->updates as $update) {
                    $id_horario = $update->id;
                    $hora_entrada = $update->horaEntrada;
                    $hora_salida = $update->horaSalida;
    
                    // Obtener el horario actual
                    $horarioActual = $tabla_horarios->find($id_horario);
    
                    if (!$horarioActual) {
                        throw new \Exception('El horario con ID: ' . $id_horario . ' no existe.');
                    }
    
                    // Comparar los valores actuales con los nuevos valores
                    if ($horarioActual->turno_entrada != $hora_entrada || $horarioActual->turno_salida != $hora_salida) {
                        $horario_data = [
                            'turno_entrada' => $hora_entrada,
                            'turno_salida' => $hora_salida
                        ];
    
                        // Actualizar horario
                        $updateHorario = $tabla_horarios->update($id_horario, $horario_data);
    
                        if (!$updateHorario) {
                            throw new \Exception('Error al actualizar el horario con ID: ' . $id_horario);
                        }
    
                        $actualizaciones_realizadas = true;
                    }
                }
    
                if (!$actualizaciones_realizadas) {
                    $mensaje['mensaje'] = 'No se realizaron cambios en las horas.';
                    $mensaje['titulo'] = '¡Sin cambios!';
                    $mensaje['error'] = 0;
                    $mensaje['tipo_mensaje'] = INFO_ALERT;
                    $mensaje['timer_message'] = 3500;
                    return $this->response->setJSON($mensaje);
                }
    
                // Confirmar transacción
                $db->transCommit();
    
                $mensaje['mensaje'] = 'Las horas se han actualizado correctamente.';
                $mensaje['titulo'] = '¡Actualización exitosa!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $db->transRollback();
    
                $mensaje['mensaje'] = 'Error al actualizar las horas. ' . $e->getMessage();
                $mensaje['titulo'] = '¡Error al actualizar!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
        } else {
            $mensaje['mensaje'] = 'No tienes permiso para realizar esta acción.';
            $mensaje['titulo'] = '¡Permiso denegado!';
            $mensaje['error'] = -1;
            $mensaje['tipo_mensaje'] = DANGER_ALERT;
            $mensaje['timer_message'] = 3500;
            return $this->response->setJSON($mensaje);
        }
    }
    

} //end 