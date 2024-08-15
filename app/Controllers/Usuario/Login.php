<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;

class Login extends BaseController
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
            return $this->crear_vista("usuario/login");
        }
    }

    private function crear_vista($nombre_vista)
    {
        return view($nombre_vista);
    }

    public function comprobar()
    {
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $tabla_usuarios = new \App\Models\Tabla_usuarios;
        $usuario = $tabla_usuarios->login($email, hash("sha256", $password));

        log_message('info', 'Iniciando proceso de login para el email: ' . $email);

        if ($usuario != null) {
            log_message('info', 'Usuario encontrado: ' . $usuario->nombre_usuario);

            if ($usuario->estatus_usuario == ESTATUS_DESHABILITADO ) {
                mensaje('El usuario no está habilitado, por favor contacte al administrador.', WARNING_ALERT, '¡Usuario inhabilitado!');
                log_message('info', 'Usuario deshabilitado: ' . $email);
                return redirect()->to(route_to('login'));
            }

            $session = session();
            $session->set("sesion_iniciada", TRUE);
            $session->set("id_usuario", $usuario->id_usuario);
            $session->set("nombre_usuario", $usuario->nombre_usuario);
            $session->set("nombre_completo_usuario", $usuario->nombre_usuario . ' ' . $usuario->ap_paterno_usuario . ' ' . $usuario->ap_materno_usuario);
            $session->set("sexo_usuario", $usuario->sexo_usuario);
            $session->set("email_usuario", $usuario->email_usuario);
            $session->set("imagen_usuario", $usuario->imagen_usuario);
            $session->set("rol_actual", array('nombre' => $usuario->nombre_rol, 'clave' => $usuario->clave_rol));

            // Redirigir según el rol del usuario
            switch ($usuario->clave_rol) {
                case ROL_SUPERADMIN['clave']:
                    $session->set("tarea_actual", TAREA_SUPERADMIN_DASHBOARD);
                    log_message('info', 'Redirigiendo a dashboard para el rol SUPERADMIN');
                    return redirect()->to(route_to('dashboard_superadmin'));
                case ROL_ADMIN['clave']:
                    $session->set("tarea_actual", TAREA_ADMIN_DASHBOARD);
                    log_message('info', 'Redirigiendo a dashboard para el rol ADMIN');
                    return redirect()->to(route_to('dashboard_admin'));
                case ROL_PSICOLOGO['clave']:
                    $session->set("tarea_actual", TAREA_PSICOLOGO_DASHBOARD);
                    log_message('info', 'Redirigiendo a dashboard_psicologo para el rol PSICOLOGO');
                    return redirect()->to(route_to('dashboard_psicologo'));
                case ROL_PACIENTE['clave']:
                    $session->set("tarea_actual", TAREA_PACIENTE_DASHBOARD);
                    log_message('info', 'Redirigiendo a dashboard_paciente para el rol PACIENTE');
                    return redirect()->to(route_to('dashboard_paciente'));
                default:
                    log_message('info', 'Redirigiendo al login');
                    return redirect()->to(route_to('login'));
            }

            if ($usuario->sexo_usuario == SEXO_MASCULINO)
                mensaje("Bienvenido a la " . NOMBRE_SISTEMA, INFO_ALERT, "¡Hola " . $session->nombre_usuario . '!', 3500);
            else
                mensaje("Bienvenida a la " . NOMBRE_SISTEMA, INFO_ALERT, "¡Hola " . $session->nombre_usuario . '!', 3500);

            log_message('info', 'Redirigiendo según el rol del usuario: ' . $usuario->clave_rol);
        } else {
            mensaje('Tu correo y/o contraseña son incorrectos. Intenta nuevamente, por favor.', DANGER_ALERT, '¡Credenciales incorrectas!', 3000);
            log_message('info', 'Credenciales incorrectas para el email: ' . $email);
            return redirect()->to(route_to('login'));
        }
    }
}