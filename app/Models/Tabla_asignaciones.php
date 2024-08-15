<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_asignaciones extends Model
{
    protected $table      = 'asignaciones';
    protected $primaryKey = 'id_asignacion';
    protected $returnType = 'object';
    protected $allowedFields = ['id_asignacion', 'id_paciente', 'id_psicologo', 'fecha_asignacion', 'descripcion', ' estatus_asignacion', 'fecha_actualizacion'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;


    public function datatable_asignaciones($rol_actual = 0)
    {
        if ($rol_actual == ROL_ADMIN['clave']) {
            $resultado = $this
                ->select(
                    '
                asignaciones.id_asignacion,
                asignaciones.id_paciente,
                asignaciones.id_psicologo,
                asignaciones.fecha_asignacion, 
                paciente.nombre_usuario as nombre_paciente,
                paciente.ap_paterno_usuario as ap_paterno_paciente,
                paciente.ap_materno_usuario as ap_materno_paciente,
                psicologo.nombre_usuario as nombre_psicologo,
                psicologo.ap_paterno_usuario as ap_paterno_psicologo,
                psicologo.ap_materno_usuario as ap_materno_psicologo,
                psicologos.numero_trabajador_psicologo,
                pacientes.id_subcate,
                alumnos.matricula,
                administrativos.numero_trabajador_administrativo,
                invitados.identificador
                '
                )
                ->join('alumnos', 'alumnos.id_paciente = asignaciones.id_paciente', 'left')
                ->join('invitados', 'invitados.id_paciente = asignaciones.id_paciente', 'left')
                ->join('administrativos', 'administrativos.id_paciente = asignaciones.id_paciente', 'left')
                ->join('psicologos', 'psicologos.id_psicologo = asignaciones.id_psicologo')
                ->join('pacientes', 'pacientes.id_paciente = asignaciones.id_paciente')
                ->join('usuarios as paciente', 'paciente.id_usuario = asignaciones.id_paciente')
                ->join('usuarios as psicologo', 'psicologo.id_usuario = asignaciones.id_psicologo')
                ->orderBy('paciente.nombre_usuario', 'ASC')
                ->findAll();

            return $resultado;
        }
    } //end obtener_historial_asignaciones

    public function obtener_asignacion($id_asignacion = 0)
    {

        $resultado = $this
            ->select('
            asignaciones.id_asignacion,
            asignaciones.id_paciente,
            paciente.nombre_usuario as nombre_paciente,
            paciente.ap_paterno_usuario as ap_paterno_paciente,
            paciente.ap_materno_usuario as ap_materno_paciente,
            psicologos.numero_trabajador_psicologo,
            psicologos.id_psicologo,
            administrativos.numero_trabajador_administrativo,
            pacientes.id_subcate,
            alumnos.matricula,
            administrativos.numero_trabajador_administrativo,
            invitados.identificador
        ')
            ->join('alumnos', 'alumnos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('psicologos', 'psicologos.id_psicologo = asignaciones.id_psicologo')
            ->join('pacientes', 'pacientes.id_paciente = asignaciones.id_paciente')
            ->join('usuarios as paciente', 'paciente.id_usuario = asignaciones.id_paciente')
            ->join('usuarios as psicologo', 'psicologo.id_usuario = asignaciones.id_psicologo')
            ->where('asignaciones.id_asignacion', $id_asignacion)
            ->first();

        return $resultado;
    }

    public function datatable_pacientes_asignados($id_psicologo)
    {
        //  consulta para obtener los pacientes asignados a un psicólogo específico
        $resultado = $this
            ->select(
                '
            asignaciones.id_paciente, 
            usuarios.nombre_usuario,
            usuarios.ap_paterno_usuario,
            usuarios.ap_materno_usuario,
            usuarios.sexo_usuario, 
            usuarios.fecha_nacimiento_usuario, 
            usuarios.email_usuario, 
            pacientes.id_subcate, 
            alumnos.matricula,
            administrativos.numero_trabajador_administrativo,
            invitados.identificador'
            )
            ->join('alumnos', 'alumnos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('usuarios', 'usuarios.id_usuario = asignaciones.id_paciente')
            ->join('psicologos', 'psicologos.id_psicologo = asignaciones.id_psicologo')
            ->join('pacientes', 'pacientes.id_paciente = asignaciones.id_paciente')
            ->where('asignaciones.id_psicologo', $id_psicologo)
            ->orderBy('usuarios.nombre_usuario', 'ASC')
            ->findAll();

        return $resultado;

        
    }



    public function obtener_paciente_asignado($id_paciente = 0)
    {

        $resultado = $this
            ->select(
                '
            usuarios.nombre_usuario,
            usuarios.ap_paterno_usuario,
            usuarios.ap_materno_usuario,
            usuarios.sexo_usuario, 
            usuarios.fecha_nacimiento_usuario, 
            usuarios.email_usuario,
            usuarios.imagen_usuario,
            pacientes.id_subcate,
            pacientes.numero_expediente,
            pacientes.id_tipo_referencia,
            pacientes.id_tipo_atencion,
            alumnos.matricula,
            alumnos.id_programa,
            administrativos.numero_trabajador_administrativo,
            administrativos.id_area,
            invitados.identificador
            '
            )
            ->join('alumnos', 'alumnos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('usuarios', 'usuarios.id_usuario = asignaciones.id_paciente')
            ->join('pacientes', 'pacientes.id_paciente = asignaciones.id_paciente')
            ->where('asignaciones.id_paciente', $id_paciente)
            ->first();

        return $resultado;
    }

    public function obtener_psicologo_asignado($id_paciente = 0)
    {
        $resultado = $this
            ->select(
                '
                usuarios.id_usuario AS id_psicologo,
                usuarios.nombre_usuario AS nombre_psicologo,
                usuarios.ap_paterno_usuario AS ap_paterno_psicologo,
                usuarios.ap_materno_usuario AS ap_materno_psicologo,
                usuarios.email_usuario AS email_psicologo,
                usuarios.imagen_usuario AS imagen_psicologo
                '
            )
            ->join('usuarios', 'usuarios.id_usuario = asignaciones.id_psicologo') // Obtenemos solo los datos del psicólogo
            ->where('asignaciones.id_paciente', $id_paciente)
            ->first();
    
        return $resultado;
    }
    



    public function datatable_historial_pacientes($id_psicologo = 0)
    {

        $resultado = $this
            ->select(
                '
            alumnos.matricula,
            administrativos.numero_trabajador_administrativo,
            invitados.identificador,
            paciente.nombre_usuario as nombre_paciente,
            paciente.ap_paterno_usuario as ap_paterno_paciente,
            paciente.ap_materno_usuario as ap_materno_paciente,
            pacientes.id_subcate,
            historial_asignaciones.nuevo_estatus,
            historial_asignaciones.fecha_historial,
            historial_asignaciones.descripcion
            '
            )
            ->join('alumnos', 'alumnos.id_paciente = asignaciones.id_paciente', 'left')
            ->join('invitados', 'invitados.id_paciente = asignaciones.id_paciente', 'left')
            ->join('administrativos', 'administrativos.id_paciente = asignaciones.id_paciente', 'left')
            ->join('historial_asignaciones', ' historial_asignaciones.id_asignacion = asignaciones.id_asignacion')
            ->join('psicologos', 'psicologos.id_psicologo = asignaciones.id_psicologo')
            ->join('pacientes', 'pacientes.id_paciente = asignaciones.id_paciente')
            ->join('usuarios as paciente', 'paciente.id_usuario = asignaciones.id_paciente')
            ->where('asignaciones.id_psicologo', $id_psicologo)
            ->orderBy('paciente.nombre_usuario', 'ASC')
            ->findAll();
        return $resultado;
    }
}
