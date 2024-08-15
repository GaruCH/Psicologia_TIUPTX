<?php

namespace App\Controllers\Panel;


use CodeIgniter\I18n\Time;
use App\Libraries\Permisos;
use App\Models\Tabla_citas;
use App\Controllers\BaseController;
use App\Models\Tabla_historial_citas;
use App\Models\Tabla_pacientes;

class Paciente_citas extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PACIENTE_CITAS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PACIENTE_CITAS;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/pacientes_citas", $this->cargar_datos());
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



        $datos['nombre_pagina'] = 'Administración Citas';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Citas',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Citas');

        // Cargar notificaciones utilizando el helper
        $datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

        return $datos;
    } //end cargar_datos

    private function crear_vista($nombre_vista, $contenido = array())
    {
        $session = session();
        // Cargar el modelo de asignaciones
        $tabla_asignacion = new \App\Models\Tabla_asignaciones();
        $psicologo = $tabla_asignacion->obtener_psicologo_asignado($session->id_usuario);


        $contenido['id_psicologo'] = $psicologo->id_psicologo;
        $contenido['nombre_psicologo'] = $psicologo->nombre_psicologo . ' ' . $psicologo->ap_paterno_psicologo . ' ' . $psicologo->ap_materno_psicologo;
        $contenido['id_paciente'] = $session->id_usuario;
        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista

    public function generar_datatable_citas()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_citas = new Tabla_citas();
            $citas = $tabla_citas->datatable_citas_paciente($session->id_usuario);
            $data = array();
            $count = 0;
            foreach ($citas as $cita) {
                $sub_array = array();
                $acciones = '';
                $imgestadoP = '';
                $imgestadoA = '';
                $imgestadoP .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Pendiente-Sistema_UPTX.svg') . '" alt="Cita pendiente">';
                $imgestadoA .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Aceptado-Sistema_UPTX.svg') . '" alt="Cita aceptada">';
                $sub_array['total'] = ++$count;

                $sub_array['nombre_psicologo'] = $cita->nombre_psicologo . ' ' . $cita->ap_paterno_psicologo . ' ' . $cita->ap_materno_psicologo;

                $sub_array['descripcion_cita'] = $cita->descripcion_cita;

                $sub_array['fecha_cita'] = $cita->fecha_cita;

                $sub_array['hora_cita'] = $cita->hora_cita;

                if ($cita->estatus_cita == ESTATUS_PENDIENTE) {
                    $sub_array['estado_cita'] = $imgestadoP;
                    // Botón de Cancelar
                    $acciones .= '<button type="button" class="btn btn-outline-danger btn-sm eliminar-cita" id="' . $cita->id_cita . '" data-toggle="tooltip" data-placement="top" title="Cancelar">Cancelar cita</button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                } elseif ($cita->estatus_cita == ESTATUS_CONFIRMADA) {
                    $sub_array['estado_cita'] = $imgestadoA;
                }
                $sub_array['acciones'] = $acciones;
                $data[] = $sub_array;
            } //end foreach psicologos
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_psicologos


    public function obtener_horas_disponibles($dia, $id_psicologo, $fecha)
    {
        $tabla_horarios = new \App\Models\Tabla_horarios;
        $tabla_citas = new Tabla_citas();

        // Obtener el horario del psicólogo para el día especificado
        $horario = $tabla_horarios->horarioExists($id_psicologo, $dia);

        if ($horario) {
            // Obtener las horas ocupadas
            $citas = $tabla_citas->obtenerHorasOcupadas($id_psicologo, $fecha);

            // Crear un array de horas ocupadas (convertidas al formato H:i)
            $horas_ocupadas = array_map(function ($cita) {
                return date('H:i', strtotime($cita->hora_cita)); // Acceso correcto como objeto
            }, $citas);

            // Generar las horas disponibles
            $horas_disponibles = array();
            $hora_actual = strtotime($horario->turno_entrada);
            $hora_salida = strtotime($horario->turno_salida);

            while ($hora_actual < $hora_salida) {
                $hora_inicio = date('H:i', $hora_actual);
                $hora_fin = date('H:i', strtotime('+1 hour', $hora_actual));

                // Si la hora actual no está ocupada
                if (!in_array($hora_inicio, $horas_ocupadas)) {
                    // Formatear la hora como "8:00 - 9:00"
                    $horas_disponibles[] = [
                        'value' => $hora_inicio,
                        'text' => $hora_inicio . ' - ' . $hora_fin
                    ];
                }

                $hora_actual = strtotime('+1 hour', $hora_actual);
            }

            // Devolver la respuesta JSON
            return $this->response->setJSON(['horas_disponibles' => $horas_disponibles]);
        } else {
            return $this->response->setJSON(['error' => 'No se encontró horario disponible para el día seleccionado.']);
        }
    }

    public function verificar_fecha_valida($diaNumero, $id_psicologo)
    {
        // Lógica para verificar si la fecha es válida para el psicólogo
        $tabla_horarios = new \App\Models\Tabla_horarios;

        $horario = $tabla_horarios->horarioExists($id_psicologo, $diaNumero);
        if ($horario) {
            return $this->response->setJSON(['fecha_valida' => true]);
        } else {
            return $this->response->setJSON(['fecha_valida' => false]);
        }
    }

    public function registrar_cita()
    {
        if ($this->permitido) {
            $mensaje = array();
            $id_paciente = $this->request->getPost('id_paciente'); // Obtener ID del paciente
            $descripcion = $this->request->getPost('descripcion');
            $fecha_cita = $this->request->getPost('fecha_cita');
            $hora_cita = $this->request->getPost('hora_cita');
            $id_psicologo = $this->request->getPost('id_psicologo');

            // Validar que todos los datos necesarios estén presentes
            if (!$id_paciente || !$descripcion || !$fecha_cita || (!$hora_cita && $hora_cita !== '')) {
                $mensaje['mensaje'] = 'Todos los campos deben ser completados.';
                $mensaje['titulo'] = '¡Error al registrar cita!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }

            $tabla_paciente = new Tabla_pacientes();
            $paciente = $tabla_paciente->obtener_paciente($id_paciente);
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Insertar la cita en la tabla de citas
                $tabla_citas = new Tabla_citas();
                $citaData = [
                    'id_paciente' => $id_paciente,
                    'descripcion_cita' => $descripcion,
                    'fecha_cita' => $fecha_cita,
                    'hora_cita' => $hora_cita,
                    'id_psicologo' => $id_psicologo,
                    'estatus_cita' => ESTATUS_PENDIENTE
                ];

                $insertedCitaId = $tabla_citas->insert($citaData);

                // Datos de la notificación
                $notificacionData = [
                    'id_usuario' => $id_psicologo,
                    'titulo_notificacion' => 'Cita por confirmar', // Título de la notificación
                    'tipo_notificacion' => 'warning', // Tipo de notificación
                    'mensaje' => 'El paciente ' .
                        $paciente->nombre_usuario . ' ' .
                        $paciente->ap_paterno_usuario . ' ' .
                        $paciente->ap_materno_usuario . ' Ha agendado una cita.',
                    'leida' => 0 // 0 indica que la notificación no ha sido leída
                ];

                // Llamar a la función para crear la notificación
                crear_notificacion($notificacionData);

                if (!$insertedCitaId) {
                    throw new \Exception('Error al insertar la cita.');
                }

                // Confirmar transacción
                $db->transCommit();

                // Mensaje de éxito
                $mensaje['mensaje'] = 'La cita ha sido registrada exitosamente.';
                $mensaje['titulo'] = '¡Registro exitoso!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;


                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $db->transRollback();

                $errorMessage = $e->getMessage();

                // Mostrar el mensaje de error
                $mensaje['mensaje'] = 'Error al registrar la cita.';
                $mensaje['titulo'] = '¡Error al registrar!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
        } else {
            return $this->response->setJSON(['error' => -1]);
        }
    }

    public function eliminar_cita()
    {
        if ($this->permitido) {
            $tabla_citas = new Tabla_citas();
            $tabla_paciente = new Tabla_pacientes();
            $cita = $tabla_citas->obtener_cita($this->request->getPost('id'));
            $paciente = $tabla_paciente->obtener_paciente($cita->id_paciente);
            // Datos de la notificación
            $notificacionData = [
                'id_usuario' => $cita->id_psicologo,
                'titulo_notificacion' => 'Cita cancelada', // Título de la notificación
                'tipo_notificacion' => 'danger', // Tipo de notificación
                'mensaje' => 'El paciente ' .
                    $paciente->nombre_usuario . ' ' .
                    $paciente->ap_paterno_usuario . ' ' .
                    $paciente->ap_materno_usuario . ' Ha cancelado la cita.',
                'leida' => 0 // 0 indica que la notificación no ha sido leída
            ];

            // Llamar a la función para crear la notificación
            crear_notificacion($notificacionData);
            
            if ($tabla_citas->delete($this->request->getPost('id'))) {
                return $this->response->setJSON(['error' => 0]);
            } //end if elimina
            else {
                return $this->response->setJSON(['error' => 1]);
            } //end else
        } //end if es un psicologo permitido
        else {
            return $this->response->setJSON(['error' => 1]);
        } //end else es un psicologo permitido
    }
}
