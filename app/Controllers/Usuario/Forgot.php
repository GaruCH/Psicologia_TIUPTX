<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;

class Forgot extends BaseController
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
                    $session->set("tarea_actual", TAREA_SUPERADMIN_DASHBOARD);
                    return redirect()->to(route_to('dashboard_superadmin'));
                case ROL_ADMIN['clave']:
                    $session->set("tarea_actual", TAREA_ADMIN_DASHBOARD);
                    return redirect()->to(route_to('dashboard_admin'));
                case ROL_PSICOLOGO['clave']:
                    $session->set("tarea_actual", TAREA_PSICOLOGO_DASHBOARD);
                    return redirect()->to(route_to('dashboard_psicologo'));
                case ROL_PACIENTE['clave']:
                    $session->set("tarea_actual", TAREA_PACIENTE_DASHBOARD);
                    return redirect()->to(route_to('dashboard_paciente'));
                default:
            }
        } else {
            // Si no hay rol definido, mostrar la vista de login
            return $this->crear_vista("usuario/forgot_password");
        }
    }

    private function crear_vista($nombre_vista)
    {
        return view($nombre_vista);
    }


    public function recuperarC()
    {
        helper(['form', 'url']);
        $tabla_usuarios = new \App\Models\Tabla_usuarios();
        $email = $this->request->getPost("emailrp");
        $usuario = $tabla_usuarios->obtener_contraseña($email);
        $opcion = $tabla_usuarios->existe_email($email);

        if ($usuario != null) {
            if ($usuario->estatus_usuario == ESTATUS_DESHABILITADO) {
                mensaje('El usuario no está habilitado, por favor contacte al administrador.', WARNING_ALERT, '¡Usuario inhabilitado!');
                return redirect()->to(route_to('login'));
            } elseif ($opcion == -100) {
                mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados.", WARNING_ALERT, "¡Correo en histórico!");
                return redirect()->to(route_to('login'));
            }

            // Generar y enviar el token de restablecimiento
            $token = $tabla_usuarios->generateResetToken($email);
            if ($token) {
                $resetLink = base_url('/restaurar_contrasena/' . $token);
                $this->enviarCorreoRestablecimiento($usuario, $resetLink);

                mensaje('Se ha enviado un enlace de restablecimiento a tu correo electrónico.', SUCCESS_ALERT, '¡Correo enviado!', 1000);
                return redirect()->to(route_to('login'));
            } else {
                mensaje('El correo electrónico no está registrado.', DANGER_ALERT, '¡Correo no registrado!', 3000);
                return redirect()->to(route_to('login'));
            }
        } else {
            mensaje('Tu correo es incorrecto. Intenta nuevamente, por favor.', DANGER_ALERT, '¡Credenciales incorrectas!', 3000);
            return redirect()->to(route_to('login'));
        }
    }

    private function enviarCorreoRestablecimiento($usuario, $resetLink)
    {
        $email = \Config\Services::email();

        if (empty($usuario->email_usuario)) {
            log_message('error', 'Datos de usuario incompletos para enviar el correo.');
            return false;
        }

        // Variables dinámicas para la plantilla
        $data = [
            'nombre_paciente' => $usuario->nombre_usuario . ' ' . $usuario->ap_paterno_usuario . ' ' . $usuario->ap_materno_usuario,
            'reset_link' => $resetLink
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
            $message = view('plantilla/email_reset_password', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
            return false;
        }

        $email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
        $email->setTo($usuario->email_usuario);
        $email->setSubject('Restablecimiento de Contraseña');
        $email->setMessage($message);

        try {
            $email->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }

    public function reset_password($token)
    {
        $tabla_usuarios = new \App\Models\Tabla_usuarios();
        $user = $tabla_usuarios->getUserByResetToken($token);

        if ($user) {
            echo view('plantilla/reset_password', ['token' => $token]);
        } else {
            mensaje('Token inválido o expirado.', DANGER_ALERT, '¡Error!', 3000);
            return redirect()->to(route_to('login'));
        }
    }

    public function update_password()
    {
        helper(['form', 'url']);
        $token = $this->request->getPost('token');
        $password = hash('sha256', $this->request->getPost('passwordc'));

        if ($this->request->getMethod() === 'post' && !empty($token) && !empty($password)) {
            $tabla_usuarios = new \App\Models\Tabla_usuarios();

            // Obtener usuario por token
            $usuario = $tabla_usuarios->getUserByToken($token);
            if ($usuario) {
                // Comparar nueva contraseña con la contraseña actual
                if ($password === $usuario->password_usuario) {
                    mensaje('La nueva contraseña no puede ser igual a la anterior.', WARNING_ALERT, '¡Advertencia!', 3000);
                    return redirect()->back()->withInput();
                }

                // Restablecer la contraseña si no es la misma
                if ($tabla_usuarios->resetPassword($token, $password)) {
                    mensaje('Tu contraseña ha sido restablecida exitosamente.', SUCCESS_ALERT, '¡Contraseña restablecida!', 3000);
                    return redirect()->to(route_to('login'));
                } else {
                    mensaje('Token inválido o expirado.', DANGER_ALERT, '¡Error!', 3000);
                    return redirect()->to(route_to('login'));
                }
            } else {
                mensaje('Usuario no encontrado.', DANGER_ALERT, '¡Error!', 3000);
                return redirect()->to(route_to('login'));
            }
        }

        mensaje('Error al restablecer la contraseña.', DANGER_ALERT, '¡Error!', 3000);
        return redirect()->to(route_to('login'));
    }
}
