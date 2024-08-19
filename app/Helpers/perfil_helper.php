<?php

use App\Models\Tabla_usuarios;
use App\Models\Tabla_pacientes;
use App\Models\Tabla_psicologos;
use App\Models\Tabla_alumnos;
use App\Models\Tabla_programas_educativos;
use App\Models\Tabla_administrativos;
use App\Models\Tabla_areas;
use App\Models\Tabla_invitados;


function cargarPerfilUsuario($session)
{
    $session =  session();

    $tabla_usuarios = new Tabla_usuarios();
    $tabla_pacientes = new Tabla_pacientes();
    $tabla_psicologo = new Tabla_psicologos();
    $tabla_alumnos = new Tabla_alumnos();
    $tabla_programas = new Tabla_programas_educativos();
    $tabla_administrativos = new Tabla_administrativos();
    $tabla_areas = new Tabla_areas();
    $tabla_invitados = new Tabla_invitados();

    $usuario = $tabla_usuarios->obtener_usuario($session->id_usuario);
    $contenido['nombre'] = $usuario->nombre_usuario;
    $contenido['ap_paterno'] = $usuario->ap_paterno_usuario;
    $contenido['ap_materno'] = $usuario->ap_materno_usuario;
    $contenido['sexo'] = $usuario->sexo_usuario;

    // Definir la imagen por defecto basada en el sexo
    $imagen_default = ($usuario->sexo_usuario === SEXO_FEMENINO) ? 'no-image-f.png' : 'no-image-m.png';

    // Verificar si la imagen del usuario está disponible
    $imagen_usuario = !empty($usuario->imagen_usuario) ?  $usuario->imagen_usuario : $imagen_default;

    $contenido['email'] = $usuario->email_usuario;
    $contenido['rol'] = $session->rol_actual['clave'];
    $contenido['imagen'] = $imagen_usuario;
    $contenido['id_usuario'] = $session->id_usuario;

    switch ($session->rol_actual['clave']) {
        case ROL_SUPERADMIN['clave']:
            $contenido['nombre_r'] = 'superadmin';
            break;
        case ROL_ADMIN['clave']:
            $contenido['nombre_r'] = 'admin';
            break;
        case ROL_PSICOLOGO['clave']:
            $contenido['nombre_r'] = 'psicologo';
            $psicologo = $tabla_psicologo->obtener_psicologo($session->id_usuario);
            $contenido['numero_trabajador_psicologo'] = $psicologo->numero_trabajador_psicologo;
            break;
        case ROL_PACIENTE['clave']:
            $contenido['nombre_r'] = 'paciente';
            $paciente = $tabla_pacientes->obtener_paciente($session->id_usuario);
            $contenido['expediente'] = $paciente->numero_expediente;
            $contenido['tipo_paciente'] = $paciente->id_subcate;

            // Lógica para tipo de referencia
            switch ($paciente->id_tipo_referencia) {
                case TIPO_REFERENCIA_OTRO['clave']:
                    $contenido['referencia'] = 'Otro';
                    break;
                case TIPO_REFERENCIA_SERVICIO_MEDICO['clave']:
                    $contenido['referencia'] = 'Servicio Médico';
                    break;
                case TIPO_REFERENCIA_DIRECTOR_CARRERA['clave']:
                    $contenido['referencia'] = 'Director de Carrera';
                    break;
                case TIPO_REFERENCIA_TUTOR['clave']:
                    $contenido['referencia'] = 'Tutor';
                    break;
            }

            // Lógica para tipo de atención
            switch ($paciente->id_tipo_atencion) {
                case TIPO_ATENCION_PRIMERA_VEZ['clave']:
                    $contenido['atencion'] = 'Primera Vez';
                    break;
                case TIPO_ATENCION_SUBSUCUENTE['clave']:
                    $contenido['atencion'] = 'Subsecuente';
                    break;
            }

            // Lógica para subcategorías de pacientes
            switch ($paciente->id_subcate) {
                case SUBCATEGORIA_ALUMNO['clave']:
                    $alumno = $tabla_alumnos->obtener_alumno($session->id_usuario);
                    $programa = $tabla_programas->obtener_programa_educativo($alumno->id_programa);
                    $contenido['matricula'] = $alumno->matricula;
                    $contenido['carrera'] = $programa->nombre_programa;
                    $contenido['papel'] = 'Alumno';
                    break;
                case SUBCATEGORIA_EMPLEADO['clave']:
                    $administrativo = $tabla_administrativos->obtener_administrativo($session->id_usuario);
                    $area = $tabla_areas->obtener_area($administrativo->id_area);
                    $contenido['numero_empleado'] = $administrativo->numero_trabajador_administrativo;
                    $contenido['area'] = $area->nombre_area;
                    $contenido['papel'] = 'Administrativo';
                    break;
                case SUBCATEGORIA_INVITADO['clave']:
                    $invitado = $tabla_invitados->obtener_invitado($session->id_usuario);
                    $contenido['identificacion'] = $invitado->identificador;
                    $contenido['papel'] = 'Invitado';
                    break;
            }
            break;
    }

    return $contenido;
}
