<?php

namespace App\Controllers\Panel;


use CodeIgniter\I18n\Time;
use App\Libraries\Permisos;
use App\Models\Tabla_citas;
use App\Controllers\BaseController;
use App\Models\Tabla_historial_citas;
use App\Models\Tabla_psicologos;

class Psicologo_citas extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_PSICOLOGO_CITAS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_PSICOLOGO_CITAS;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/psicologo_citas", $this->cargar_datos());
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

        $perfil = cargarPerfilUsuario($session);

        // Combinar el contenido existente con el perfil de usuario
        $contenido = array_merge($contenido, $perfil);

        // Cargar el modelo de asignaciones
        $tabla_asignacion = new \App\Models\Tabla_asignaciones();
        $pacientes = $tabla_asignacion->datatable_pacientes_asignados($session->id_usuario);

        // Transformar el resultado en un array adecuado para form_dropdown
        $pacientes_opciones = ['' => 'Seleccione un paciente...'];
        foreach ($pacientes as $paciente) {
            $pacientes_opciones[$paciente->id_paciente] = $paciente->nombre_usuario . ' ' . $paciente->ap_paterno_usuario . ' ' . $paciente->ap_materno_usuario;
        }
        $contenido['id_psicologo'] = $session->id_usuario;
        // Pasar los pacientes a la vista
        $contenido['pacientes'] = $pacientes_opciones;

        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista

    public function generar_datatable_citas()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_citas = new Tabla_citas();
            $citas = $tabla_citas->datatable_citas($session->id_usuario);
            $data = array();
            $count = 0;
            foreach ($citas as $cita) {
                $sub_array = array();
                $acciones = '';
                $imgestadoP = '';
                $imgestadoA = '';
                $imgestadoC = '';
                $imgestadoP .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Pendiente-Sistema_UPTX.svg') . '" alt="Cita pendiente">';
                $imgestadoA .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Aceptado-Sistema_UPTX.svg') . '" alt="Cita aceptada">';
                $imgestadoC .= '<img src="' . base_url(RECURSOS_PANEL_IMAGENES . '/Icono_Cancelado-Sistema_UPTX.svg') . '" alt="Cita cancelada">';
                $sub_array['total'] = ++$count;

                if ($cita->id_subcate == SUBCATEGORIA_ALUMNO['clave']) {
                    $sub_array['identificador'] = $cita->matricula;
                } elseif ($cita->id_subcate == SUBCATEGORIA_EMPLEADO['clave']) {
                    $sub_array['identificador'] =  $cita->numero_trabajador_administrativo;
                } elseif ($cita->id_subcate == SUBCATEGORIA_INVITADO['clave']) {
                    $sub_array['identificador'] = $cita->identificador;
                }

                $sub_array['nombre_paciente'] = $cita->nombre_paciente . ' ' . $cita->ap_paterno_paciente . ' ' . $cita->ap_materno_paciente;

                $sub_array['descripcion_cita'] = $cita->descripcion_cita;

                $sub_array['fecha_cita'] = $cita->fecha_cita;

                $sub_array['hora_cita'] = $cita->hora_cita;

                if ($cita->estatus_cita == ESTATUS_PENDIENTE) {
                    $sub_array['estado_cita'] = $imgestadoP;
                    // Botón de Confirmar
                    $acciones .= '<button type="button" class="btn btn-outline-success btn-sm confirmar-cita" id="' . $cita->id_cita . '_' . $cita->estatus_cita . '" data-toggle="tooltip" data-placement="top" title="Confirmar">Confirmar</button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';

                    // Botón de Cancelar
                    $acciones .= '<button type="button" class="btn btn-outline-danger btn-sm cancelar-cita" id="' . $cita->id_cita . '_' . $cita->estatus_cita . '" data-toggle="tooltip" data-placement="top" title="Cancelar">Cancelar</button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                } elseif ($cita->estatus_cita == ESTATUS_CONFIRMADA) {
                    $sub_array['estado_cita'] = $imgestadoA;
                    // Botón de Concluida
                    $acciones .= '<button type="button" class="btn btn-outline-info btn-sm concluir-cita" id="' . $cita->id_cita . '_' . $cita->estatus_cita . '" data-toggle="tooltip" data-placement="top" title="Concluir">Concluir</button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                } elseif ($cita->estatus_cita == ESTATUS_CANCELADA) {
                    $sub_array['estado_cita'] = $imgestadoC;
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

    public function cambiar_estatus_cita_aceptar()
    {
        if ($this->permitido) {
            // Obtener el ID de la cita y el nuevo estatus
            $id_cita = $this->request->getPost('id');
            $status = $this->request->getPost('estatus');
            // Instanciar modelos
            $citasModel = new Tabla_citas();
            $tabla_historial = new Tabla_historial_citas();
            $tabla_psicologo = new Tabla_psicologos();
            // Obtener los datos de la cita original
            $cita = $citasModel->find($id_cita);
            $psicologo = $tabla_psicologo->obtener_psicologo($cita->id_psicologo);

            if (!$cita) {
                return $this->response->setJSON(['error' => 1, 'message' => 'Cita no encontrada.']);
            }


            $historial_data_original = [
                'id_cita' => $id_cita,
                'estatus_anterior' => $cita->estatus_cita,
                'nuevo_estatus' => $status,
                'fecha_historial' => date('Y-m-d H:i:s'),
                'descripcion' => 'Cita confirmada.',
            ];

            $tabla_historial->insert($historial_data_original);

            // Crear notificación para la confirmación de la cita
            // Datos de la notificación
            $notificacionData = [
                'id_usuario' => $cita->id_paciente,
                'titulo_notificacion' => 'Cita confirmada', // Título de la notificación
                'tipo_notificacion' => 'success', // Tipo de notificación
                'mensaje' => 'El psicólogo ' .
                    $psicologo->nombre_usuario . ' ' .
                    $psicologo->ap_paterno_usuario . ' ' .
                    $psicologo->ap_materno_usuario . ' ha confirmado su cita.',
                'leida' => 0 // 0 indica que la notificación no ha sido leída
            ];

            // Llamar a la función para crear la notificación
            crear_notificacion($notificacionData);

            // Actualizar el estatus en la tabla de citas
            $citasModel->update($id_cita, ['estatus_cita' => ESTATUS_CONFIRMADA]);


            // Respuesta exitosa
            return $this->response->setJSON(['error' => 0]);
        } else {
            return $this->response->setJSON(['error' => 1]);
        }
    }

    public function cambiar_estatus_cita_cancelar()
    {
        if ($this->permitido) {
            // Obtener el ID de la cita y el nuevo estatus
            $id_cita = $this->request->getPost('id');
            $status = $this->request->getPost('estatus');
            // Instanciar modelos
            $citasModel = new Tabla_citas();
            $tabla_historial = new Tabla_historial_citas();
            $tabla_psicologo = new Tabla_psicologos();
            // Obtener los datos de la cita original
            $cita = $citasModel->find($id_cita);
            $psicologo = $tabla_psicologo->obtener_psicologo($cita->id_psicologo);


            if (!$cita) {
                return $this->response->setJSON(['error' => 1, 'message' => 'Cita no encontrada.']);
            }


            $historial_data_original = [
                'id_cita' => $id_cita,
                'estatus_anterior' => $cita->estatus_cita,
                'nuevo_estatus' => $status,
                'fecha_historial' => date('Y-m-d H:i:s'),
                'descripcion' => 'Cita cancelada.',
            ];

            $tabla_historial->insert($historial_data_original);

            $tabla_historial->insert($historial_data_original);

            // Crear notificación para la confirmación de la cita
            // Datos de la notificación
            $notificacionData = [
                'id_usuario' => $cita->id_paciente,
                'titulo_notificacion' => 'Cita cancelada', // Título de la notificación
                'tipo_notificacion' => 'danger', // Tipo de notificación
                'mensaje' => 'El psicólogo ' .
                    $psicologo->nombre_usuario . ' ' .
                    $psicologo->ap_paterno_usuario . ' ' .
                    $psicologo->ap_materno_usuario . ' ha cancelado su cita.',
                'leida' => 0 // 0 indica que la notificación no ha sido leída
            ];

            // Llamar a la función para crear la notificación
            crear_notificacion($notificacionData);

            // Actualizar el estatus en la tabla de citas
            $citasModel->update($id_cita, ['estatus_cita' => ESTATUS_CANCELADA]);


            // Respuesta exitosa
            return $this->response->setJSON(['error' => 0]);
        } else {
            return $this->response->setJSON(['error' => 1]);
        }
    }

    public function cambiar_estatus_cita_concluir()
    {
        if ($this->permitido) {
            // Obtener el ID de la cita y el nuevo estatus
            $id_cita = $this->request->getPost('id');
            $status = $this->request->getPost('estatus');
            // Instanciar modelos
            $citasModel = new Tabla_citas();
            $tabla_historial = new Tabla_historial_citas();

            // Obtener los datos de la cita original
            $cita = $citasModel->find($id_cita);

            if (!$cita) {
                return $this->response->setJSON(['error' => 1, 'message' => 'Cita no encontrada.']);
            }


            $historial_data_original = [
                'id_cita' => $id_cita,
                'estatus_anterior' => $cita->estatus_cita,
                'nuevo_estatus' => $status,
                'fecha_historial' => date('Y-m-d H:i:s'),
                'descripcion' => 'Cita concluida.',
            ];

            $tabla_historial->insert($historial_data_original);

            // Actualizar el estatus en la tabla de citas
            $citasModel->update($id_cita, ['estatus_cita' => ESTATUS_CONCLUIDA]);


            // Respuesta exitosa
            return $this->response->setJSON(['error' => 0]);
        } else {
            return $this->response->setJSON(['error' => 1]);
        }
    }

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
            $id_paciente = $this->request->getPost('pacientes'); // Obtener ID del paciente
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
}
