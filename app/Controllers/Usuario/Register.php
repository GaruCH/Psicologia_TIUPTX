<?php

namespace App\Controllers\Usuario;

use App\Models\Tabla_usuarios;
use App\Models\Tabla_pacientes;
use App\Models\Tabla_administrativos;
use App\Models\Tabla_alumnos;
use App\Models\Tabla_invitados;
use App\Models\Tabla_psicologos;
use App\Models\Tabla_historial_asignaciones;
use App\Controllers\BaseController;

class Register extends BaseController
{

    public function index()
    {
        $session = session();

        // Verificar si el rol está definido en la sesión
        if ($session->has('rol_actual')) {
            $rol_actual = $session->get('rol_actual')['clave'];

            // Redirigir según el rol del usuario
            switch ($rol_actual) {
                case ROL_SUPERADMIN['clave']:
                    $session->set("tarea_actual", TAREA_DASHBOARD);
                    return redirect()->to(route_to('dashboard'));
                case ROL_ADMIN['clave']:
                    $session->set("tarea_actual", TAREA_DASHBOARD);
                    return redirect()->to(route_to('dashboard'));
                case ROL_PSICOLOGO['clave']:
                    $session->set("tarea_actual", TAREA_PSICOLOGO_DASHBOARD);
                    return redirect()->to(route_to('dashboard_psicologo'));
                case ROL_PACIENTE['clave']:
                    $session->set("tarea_actual", TAREA_PACIENTE_DASHBOARD);
                    return redirect()->to(route_to('dashboard_paciente'));
                default:
                    return redirect()->to(route_to('login'));
            }
        } else {

            $tipo = trim($this->request->getVar('tipo'));

            // Define los tipos válidos
            $tipos_validos = ['alumno', 'administrativo', 'invitado'];

            // Verifica si el tipo es uno de los valores válidos
            if (in_array($tipo, $tipos_validos, true)) {
                switch ($tipo) {
                    case 'alumno':
                        $alumnos = "usuario/registro_alumno";
                        return $this->crear_vista($alumnos, $tipo);
                    case 'administrativo':
                        $administrativos = "usuario/registro_administrativos";
                        return $this->crear_vista($administrativos, $tipo);
                    case 'invitado':
                        $invitados = "usuario/registro_invitado";
                        return $this->crear_vista($invitados, $tipo);
                    default:
                        // Este caso no debería ocurrir, pero se incluye por seguridad adicional
                        mensaje("Tipo de registro no válido", DANGER_ALERT, "¡Error!");
                        return redirect()->to(route_to('login'));
                }
            } else {
                mensaje("Debe seleccionar un tipo de registro válido", DANGER_ALERT, "¡Error!");
                return redirect()->to(route_to('login'));
            }
        }
    }

    private function crear_vista($nombre_vista, $tipo)
    {
        // Cargar el modelo de referencias
        $tabla_referencias = new \App\Models\Tabla_tipos_referencias();
        $referencias = $tabla_referencias->obtener_tipos_referencias();

        // Transformar el resultado en un array adecuado para form_dropdown
        $referencias_opciones = ['' => 'Seleccione una referencia...'];
        foreach ($referencias as $clave => $nombre) {
            $referencias_opciones[$clave] = $nombre;
        }

        // Datos de referencias
        $data_referencias = [
            'referencias' => $referencias_opciones
        ];

        // Procesar según el tipo
        switch ($tipo) {
            case 'alumno':
                // Cargar el modelo de carreras
                $tabla_carreras = new \App\Models\Tabla_programas_educativos();
                $carreras = $tabla_carreras->obtener_programas_educativos();

                // Transformar el resultado en un array adecuado para form_dropdown
                $carreras_opciones = ['' => 'Seleccione una carrera...'];
                foreach ($carreras as $clave => $nombre) {
                    $carreras_opciones[$clave] = $nombre;
                }

                // Datos de carreras
                $data_carreras = [
                    'carreras' => $carreras_opciones
                ];

                // Combinar datos
                $data = array_merge($data_carreras, $data_referencias);

                // Cargar la vista con los datos combinados
                return view($nombre_vista, $data);

            case 'administrativo':

                // Cargar el modelo de Áreas
                $tabla_areas = new \App\Models\Tabla_areas();
                $areas = $tabla_areas->obtener_areas();

                // Transformar el resultado en un array adecuado para form_dropdown
                $areas_opciones = ['' => 'Seleccione un área..'];
                foreach ($areas as $clave => $nombre) {
                    $areas_opciones[$clave] = $nombre;
                }

                // Datos de carreras
                $data_areas = [
                    'areas' => $areas_opciones
                ];

                // Combinar datos
                $data = array_merge($data_areas, $data_referencias);

                // Cargar la vista con los datos combinados
                return view($nombre_vista, $data);

            case 'invitado':
                // Combinar datos solo con referencias
                $data = $data_referencias;
                return view($nombre_vista, $data);

            default:
                // Manejo de error en caso de tipo no válido
                mensaje("Tipo de registro no válido", DANGER_ALERT, "¡Error!");
                return redirect()->to(route_to('login'));
        }
    }

    public function registrar_alumno()
    {
        if ($this->request->getPost('sexo') == NULL) {
            mensaje("Debes seleccionar un sexo para el usuario", WARNING_ALERT, "¡No se pudo registrar!");
            return redirect()->to(route_to('login'));
        }

        $tabla_usuarios = new Tabla_usuarios();
        $tabla_pacientes = new Tabla_pacientes();
        $tabla_alumnos = new Tabla_alumnos();
        $tabla_psicologos = new Tabla_psicologos();
        $tabla_asignaciones = new Tabla_historial_asignaciones();

        // Datos del usuario
        $usuario = [
            'estatus_usuario' => ESTATUS_HABILITADO,
            'nombre_usuario' => $this->request->getPost('nombre'),
            'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
            'ap_materno_usuario' => $this->request->getPost('ap_materno'),
            'sexo_usuario' => $this->request->getPost('sexo'),
            'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento'),
            'email_usuario' => $this->request->getPost('emailr'),
            'id_rol' => ROL_PACIENTE['clave'],
            'password_usuario' => hash('sha256', $this->request->getPost('confirm_passwordr')),
        ];

        // Verificar si el correo ya existe
        $opcion = $tabla_usuarios->existe_email($usuario['email_usuario']);

        if ($opcion == 2 || $opcion == -100) {
            if ($opcion == 2) {
                mensaje("El correo proporcionado ya está siendo usado por otro usuario.", WARNING_ALERT, "¡Correo en uso!");
            } elseif ($opcion == -100) {
                mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados.", WARNING_ALERT, "¡Correo en uso!");
            }
            return redirect()->to(route_to('login'));
        }

        // Iniciar transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Insertar en la tabla usuario
            $insertedUserId = $tabla_usuarios->insert($usuario);

            if (!$insertedUserId) {
                throw new \Exception('Error al insertar usuario.');
            }

            // Verificar que el ID de usuario se generó correctamente
            $usuarioInsertado = $tabla_usuarios->find($insertedUserId);
            if (!$usuarioInsertado) {
                throw new \Exception('No se pudo encontrar el usuario insertado.');
            }

            // Datos del paciente
            $pacienteData = [
                'id_paciente' => $insertedUserId,
                'id_subcate' => SUBCATEGORIA_ALUMNO['clave'],
                'id_tipo_referencia' => $this->request->getPost('referencia'),
                'id_tipo_atencion' => TIPO_ATENCION_PRIMERA_VEZ['clave']
            ];

            // Insertar en la tabla paciente
            $tabla_pacientes->insert($pacienteData);

            // Datos del alumno
            $alumnoData = [
                'id_paciente' => $insertedUserId,
                'matricula' => $this->request->getPost('matricula'),
                'id_programa' => $this->request->getPost('carrera'),
            ];

            // Insertar en la tabla alumno
            $tabla_alumnos->insert($alumnoData);

            // Obtener psicólogos activos
            $psicologosActivos = $tabla_usuarios->obtener_psicologos_activos();

            if (empty($psicologosActivos)) {
                throw new \Exception('No hay psicólogos activos disponibles para la asignación.');
            }

            $psicologoAsignado = $psicologosActivos[array_rand($psicologosActivos)];

            // Datos de la asignación
            $asignacionData = [
                'id_paciente' => $insertedUserId,
                'id_psicologo' => $psicologoAsignado->id_usuario,
                'fecha_asignacion' => date('Y-m-d H:i:s'),
                'descripcion' => 'Asignación inicial del paciente al psicólogo.'
            ];

            // Insertar en la tabla historial_asignaciones
            $tabla_asignaciones->insert($asignacionData);

            // Crear notificación para el psicólogo asignado
            // Datos de la notificación
            $notificacionData = [
                'id_usuario' => $psicologoAsignado->id_usuario,
                'titulo_notificacion' => 'Nuevo Paciente Asignado', // Título de la notificación
                'tipo_notificacion' => 'info', // Tipo de notificación
                'mensaje' => 'Se te ha asignado un nuevo paciente: ' . $usuario['nombre_usuario'] . ' ' . $usuario['ap_paterno_usuario'],
                'leida' => 0, // 0 indica que la notificación no ha sido leída
                'ruta' => route_to('administracion_horarios'), // URL a la que redirigirá la notificación
            ];

            // Llamar a la función para crear la notificación
            crear_notificacion($notificacionData);

            // Obtener el usuario con la fecha de registro
            $usuarioConFecha = $tabla_usuarios->find($insertedUserId);

            // Datos del psicólogo asignado para el correo
            $datosPsicologo = [
                'nombre_psicologo' => $psicologoAsignado->nombre_usuario . ' ' . $psicologoAsignado->ap_paterno_usuario . ' ' . $psicologoAsignado->ap_materno_usuario
            ];

            // Enviar correo de confirmación
            $correoEnviado = $this->enviarCorreoConfirmacion($usuarioConFecha, $datosPsicologo);

            if ($correoEnviado === false) {
                throw new \Exception('Error al enviar correo de confirmación.');
            }

            // Confirmar transacción
            $db->transCommit();

            // Mensaje de éxito
            mensaje("Tu cuenta ha sido registrada exitosamente.", SUCCESS_ALERT, "¡Registro exitoso!");

            return redirect()->to(route_to('login'));
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();

            $errorMessage = $e->getMessage();

            // Mostrar el mensaje de error (puedes ajustar cómo lo manejas)
            mensaje("Error al registrar la cuenta: " . $errorMessage, DANGER_ALERT, "¡Error al registrar!");
            return redirect()->to(route_to('login'));
        }
    }


    public function registrar_invitado()
    {
        if ($this->request->getPost('sexo') == NULL) {
            mensaje("Debes seleccionar un sexo para el usuario", WARNING_ALERT, "¡No se pudo registrar!");
            return redirect()->to(route_to('login'));
        }

        $tabla_usuarios = new Tabla_usuarios();
        $tabla_pacientes = new Tabla_pacientes();
        $tabla_invitados = new Tabla_invitados();
        $tabla_psicologos = new Tabla_psicologos();
        $tabla_asignaciones = new Tabla_historial_asignaciones();

        // Datos del usuario
        $usuario = [
            'estatus_usuario' => ESTATUS_HABILITADO,
            'nombre_usuario' => $this->request->getPost('nombre'),
            'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
            'ap_materno_usuario' => $this->request->getPost('ap_materno'),
            'sexo_usuario' => $this->request->getPost('sexo'),
            'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento'),
            'email_usuario' => $this->request->getPost('emailr'),
            'id_rol' => ROL_PACIENTE['clave'],
            'password_usuario' => hash('sha256', $this->request->getPost('confirm_passwordr')),
        ];

        // Verificar si el correo ya existe
        $opcion = $tabla_usuarios->existe_email($usuario['email_usuario']);

        if ($opcion == 2 || $opcion == -100) {
            if ($opcion == 2) {
                mensaje("El correo proporcionado ya está siendo usado por otro usuario.", WARNING_ALERT, "¡Correo en uso!");
            } elseif ($opcion == -100) {
                mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados.", WARNING_ALERT, "¡Correo en uso!");
            }
            return redirect()->to(route_to('login'));
        }

        // Iniciar transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Insertar en la tabla usuario
            $insertedUserId = $tabla_usuarios->insert($usuario);

            if (!$insertedUserId) {
                throw new \Exception('Error al insertar usuario.');
            }

            // Verificar que el ID de usuario se generó correctamente
            $usuarioInsertado = $tabla_usuarios->find($insertedUserId);
            if (!$usuarioInsertado) {
                throw new \Exception('No se pudo encontrar el usuario insertado.');
            }


            // Datos del paciente
            $pacienteData = [
                'id_paciente' => $insertedUserId,
                'id_subcate' => SUBCATEGORIA_INVITADO['clave'],
                'id_tipo_referencia' => $this->request->getPost('referencia'),
                'id_tipo_atencion' => TIPO_ATENCION_PRIMERA_VEZ['clave']
            ];

            // Insertar en la tabla paciente
            $tabla_pacientes->insert($pacienteData);

            // Datos del alumno
            $invitadoData = [
                'id_paciente' => $insertedUserId,
                'identificador' => $this->request->getPost('identificador')
            ];

            // Insertar en la tabla alumno
            $tabla_invitados->insert($invitadoData);

            // Obtener psicólogos activos
            $psicologosActivos = $tabla_usuarios->obtener_psicologos_activos();

            if (empty($psicologosActivos)) {
                throw new \Exception('No hay psicólogos activos disponibles para la asignación.');
            }

            $psicologoAsignado = $psicologosActivos[array_rand($psicologosActivos)];

            // Datos de la asignación
            $asignacionData = [
                'id_paciente' => $insertedUserId,
                'id_psicologo' => $psicologoAsignado->id_usuario,
                'fecha_asignacion' => date('Y-m-d H:i:s'),
                'descripcion' => 'Asignación inicial del paciente al psicólogo.'
            ];

            // Insertar en la tabla historial_asignaciones
            $tabla_asignaciones->insert($asignacionData);

            // Obtener el usuario con la fecha de registro
            $usuarioConFecha = $tabla_usuarios->find($insertedUserId);

            // Datos del psicólogo asignado para el correo
            $datosPsicologo = [
                'nombre_psicologo' => $psicologoAsignado->nombre_usuario . ' ' . $psicologoAsignado->ap_paterno_usuario . ' ' . $psicologoAsignado->ap_materno_usuario
            ];

            // Enviar correo de confirmación
            $correoEnviado = $this->enviarCorreoConfirmacion($usuarioConFecha, $datosPsicologo);

            if ($correoEnviado === false) {
                throw new \Exception('Error al enviar correo de confirmación.');
            }

            // Confirmar transacción
            $db->transCommit();

            // Mensaje de éxito
            mensaje("Tu cuenta ha sido registrada exitosamente.", SUCCESS_ALERT, "¡Registro exitoso!");

            return redirect()->to(route_to('login'));
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();

            $errorMessage = $e->getMessage();

            // Mostrar el mensaje de error (puedes ajustar cómo lo manejas)
            mensaje("Error al registrar la cuenta: " . $errorMessage, DANGER_ALERT, "¡Error al registrar!");
            return redirect()->to(route_to('login'));
        }
    }

    public function registrar_administrativo()
    {
        if ($this->request->getPost('sexo') == NULL) {
            mensaje("Debes seleccionar un sexo para el usuario", WARNING_ALERT, "¡No se pudo registrar!");
            return redirect()->to(route_to('login'));
        }

        $tabla_usuarios = new Tabla_usuarios();
        $tabla_pacientes = new Tabla_pacientes();
        $tabla_administrativos = new Tabla_administrativos();
        $tabla_psicologos = new Tabla_psicologos();
        $tabla_asignaciones = new Tabla_historial_asignaciones();

        // Datos del usuario
        $usuario = [
            'estatus_usuario' => ESTATUS_HABILITADO,
            'nombre_usuario' => $this->request->getPost('nombre'),
            'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
            'ap_materno_usuario' => $this->request->getPost('ap_materno'),
            'sexo_usuario' => $this->request->getPost('sexo'),
            'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento'),
            'email_usuario' => $this->request->getPost('emailr'),
            'id_rol' => ROL_PACIENTE['clave'],
            'password_usuario' => hash('sha256', $this->request->getPost('confirm_passwordr')),
        ];

        // Verificar si el correo ya existe
        $opcion = $tabla_usuarios->existe_email($usuario['email_usuario']);

        if ($opcion == 2 || $opcion == -100) {
            if ($opcion == 2) {
                mensaje("El correo proporcionado ya está siendo usado por otro usuario.", WARNING_ALERT, "¡Correo en uso!");
            } elseif ($opcion == -100) {
                mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados.", WARNING_ALERT, "¡Correo en uso!");
            }
            return redirect()->to(route_to('login'));
        }

        // Iniciar transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Insertar en la tabla usuario
            $insertedUserId = $tabla_usuarios->insert($usuario);

            if (!$insertedUserId) {
                throw new \Exception('Error al insertar usuario.');
            }

            // Verificar que el ID de usuario se generó correctamente
            $usuarioInsertado = $tabla_usuarios->find($insertedUserId);
            if (!$usuarioInsertado) {
                throw new \Exception('No se pudo encontrar el usuario insertado.');
            }

            // Datos del paciente
            $pacienteData = [
                'id_paciente' => $insertedUserId,
                'id_subcate' => SUBCATEGORIA_EMPLEADO['clave'],
                'id_tipo_referencia' => $this->request->getPost('referencia'),
                'id_tipo_atencion' => TIPO_ATENCION_PRIMERA_VEZ['clave']
            ];

            // Insertar en la tabla paciente
            $tabla_pacientes->insert($pacienteData);

            // Datos del alumno
            $administrativoData = [
                'id_paciente' => $insertedUserId,
                'numero_trabajador_administrativo' => $this->request->getPost('numero_trabajador'),
                'id_area' => $this->request->getPost('area'),
            ];

            // Insertar en la tabla alumno
            $tabla_administrativos->insert($administrativoData);

            // Obtener psicólogos activos
            $psicologosActivos = $tabla_usuarios->obtener_psicologos_activos();

            if (empty($psicologosActivos)) {
                throw new \Exception('No hay psicólogos activos disponibles para la asignación.');
            }

            $psicologoAsignado = $psicologosActivos[array_rand($psicologosActivos)];

            // Datos de la asignación
            $asignacionData = [
                'id_paciente' => $insertedUserId,
                'id_psicologo' => $psicologoAsignado->id_usuario,
                'fecha_asignacion' => date('Y-m-d H:i:s'),
                'descripcion' => 'Asignación inicial del paciente al psicólogo.'
            ];

            // Insertar en la tabla historial_asignaciones
            $tabla_asignaciones->insert($asignacionData);

            
            // Crear notificación para el psicólogo asignado
            // Datos de la notificación
            $notificacionData = [
                'id_usuario' => $psicologoAsignado->id_usuario,
                'titulo_notificacion' => 'Nuevo Paciente Asignado', // Título de la notificación
                'tipo_notificacion' => 'info', // Tipo de notificación
                'mensaje' => 'Se te ha asignado un nuevo paciente: ' . $usuario['nombre_usuario'] . ' ' . $usuario['ap_paterno_usuario'],
                'leida' => 0, // 0 indica que la notificación no ha sido leída
                'ruta' => route_to('administracion_horarios'), // URL a la que redirigirá la notificación
            ];

            // Llamar a la función para crear la notificación
            crear_notificacion($notificacionData);
            // Obtener el usuario con la fecha de registro
            $usuarioConFecha = $tabla_usuarios->find($insertedUserId);

            // Datos del psicólogo asignado para el correo
            $datosPsicologo = [
                'nombre_psicologo' => $psicologoAsignado->nombre_usuario . ' ' . $psicologoAsignado->ap_paterno_usuario . ' ' . $psicologoAsignado->ap_materno_usuario
            ];

            // Enviar correo de confirmación
            $correoEnviado = $this->enviarCorreoConfirmacion($usuarioConFecha, $datosPsicologo);

            if ($correoEnviado === false) {
                throw new \Exception('Error al enviar correo de confirmación.');
            }

            // Confirmar transacción
            $db->transCommit();

            // Mensaje de éxito
            mensaje("Tu cuenta ha sido registrada exitosamente.", SUCCESS_ALERT, "¡Registro exitoso!");

            return redirect()->to(route_to('login'));
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();

            $errorMessage = $e->getMessage();

            // Mostrar el mensaje de error (puedes ajustar cómo lo manejas)
            mensaje("Error al registrar la cuenta: " . $errorMessage, DANGER_ALERT, "¡Error al registrar!");
            return redirect()->to(route_to('login'));
        }
    }
    // Método para generar número de expediente

    private function enviarCorreoConfirmacion($usuario, $datosPsicologo)
    {
        $email = \Config\Services::email();

        if (empty($usuario->email_usuario)) {
            log_message('error', 'Datos de usuario incompletos para enviar el correo.');
            return false;
        }

        // Variables dinámicas para la plantilla
        $data = [
            'nombre_paciente' => $usuario->nombre_usuario . ' ' . $usuario->ap_paterno_usuario . ' ' . $usuario->ap_materno_usuario,
            'rol_usuario' => ROLES[$usuario->id_rol],
            'email_usuario' => $usuario->email_usuario,
            'fecha_registro' => $usuario->creacion,
            'nombre_psicologo' => $datosPsicologo['nombre_psicologo']
        ];

        // Registrar datos para depuración
        log_message('debug', 'Datos para la vista de correo: ' . print_r($data, true));

        // Validar que las variables dinámicas no estén vacías
        foreach ($data as $key => $value) {
            if (empty($value) && !is_array($value)) {
                log_message('error', "La variable '$key' está vacía.");
                return false;
            }
        }

        // Carga la vista y reemplaza las variables
        try {
            $message = view('plantilla/email_test', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
            return false;
        }

        $email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
        $email->setTo($usuario->email_usuario);
        $email->setSubject('Información de registro');
        $email->setMessage($message);

        try {
            $email->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }
}
