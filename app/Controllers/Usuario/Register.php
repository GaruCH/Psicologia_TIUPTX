<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;
use App\Models\Tabla_subcategorias;

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
                    $session->set("tarea_actual", TAREA_DASHBOARD);
                    return redirect()->to(route_to('dashboard'));
            }
        } else {
            // Si no hay rol definido, mostrar la vista de login
            return $this->crear_vista("usuario/register");
        }
    }

    private function crear_vista($nombre_vista)
    {
        // Cargar el modelo de subcategorías
        $tabla_subcategorias = new Tabla_subcategorias();
        $subcategorias = $tabla_subcategorias->obtener_subcategorias();

        // Transformar el resultado en un array adecuado para form_dropdown
        $subcategorias_opciones = ['' => 'Seleccione una subcategoría...'];
        foreach ($subcategorias as $clave => $nombre) {
            $subcategorias_opciones[$clave] = $nombre;
        }

        // Pasar las subcategorías a la vista
        $data = [
            'subcategorias' => $subcategorias_opciones
        ];

        return view($nombre_vista, $data);
    }

    public function registrar()
    {
        if ($this->request->getPost('sexo') == NULL) {
            mensaje("Debes seleccionar un sexo para el usuario", WARNING_ALERT, "¡No se pudo registrar!");
            return redirect()->to(route_to('login'));
        }
        $tabla_usuarios = new \App\Models\Tabla_usuarios();
        $Tabla_pacientes = new \App\Models\Tabla_pacientes();

        // Datos del usuario
        $usuario = [
            'estatus_usuario' => ESTATUS_HABILITADO,
            'nombre_usuario' => $this->request->getPost('nombre'),
            'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
            'ap_materno_usuario' => $this->request->getPost('ap_materno'),
            'sexo_usuario' => $this->request->getPost('sexo'),
            'edad_usuario' => $this->request->getPost('edad'),
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

            // Datos del paciente
            $pacienteData = [
                'id_paciente' => $insertedUserId,
                'id_subcate' => $this->request->getPost('subcategoria'),
                // Ajusta 'subcategoria_paciente' según tu formulario
            ];

            // Insertar en la tabla paciente
            $Tabla_pacientes->insert($pacienteData);

            // Obtener el usuario con la fecha de registro
            $usuarioConFecha = $tabla_usuarios->find($insertedUserId);

            // Enviar correo de confirmación
            $correoEnviado = $this->enviarCorreoConfirmacion($usuarioConFecha);

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
            mensaje("Error al registrar la cuenta.", DANGER_ALERT, "¡Error al registrar!");
            return redirect()->to(route_to('login'));
        }
    }

    
    private function enviarCorreoConfirmacion($usuario)
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
            'fecha_registro' => $usuario->creacion
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