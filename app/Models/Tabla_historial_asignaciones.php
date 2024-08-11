<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_historial_asignaciones extends Model
{
    protected $table      = 'historial_asignaciones';
    protected $primaryKey = 'id_historial';
    protected $returnType = 'object';
    protected $allowedFields = ['id_historial', 'id_paciente', 'id_psicologo', 'estatus_asignacion', 'fecha_asignacion', 'descripcion'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function datatable_asignaciones($rol_actual = 0)
{
    if ($rol_actual == ROL_ADMIN['clave']) {
        $resultado = $this
            ->select(
                '
                historial_asignaciones.id_historial,
                historial_asignaciones.id_paciente,
                historial_asignaciones.id_psicologo,
                historial_asignaciones.fecha_asignacion, 
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
            ->join('alumnos', 'alumnos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('psicologos', 'psicologos.id_psicologo = historial_asignaciones.id_psicologo')
            ->join('pacientes', 'pacientes.id_paciente = historial_asignaciones.id_paciente')
            ->join('usuarios as paciente', 'paciente.id_usuario = historial_asignaciones.id_paciente')
            ->join('usuarios as psicologo', 'psicologo.id_usuario = historial_asignaciones.id_psicologo')
            ->where('historial_asignaciones.estatus_asignacion', 1) // Solo asignaciones activas
            ->orderBy('paciente.nombre_usuario', 'ASC')
            ->findAll();

        return $resultado;
    }
} //end obtener_historial_asignaciones


    public function datatable_pacientes_asignados($id_psicologo)
    {
        // Ajusta la consulta para obtener los pacientes asignados a un psicólogo específico
        $resultado = $this
            ->select(
                '
            historial_asignaciones.id_paciente, 
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
            ->join('alumnos', 'alumnos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('usuarios', 'usuarios.id_usuario = historial_asignaciones.id_paciente')
            ->join('psicologos', 'psicologos.id_psicologo = historial_asignaciones.id_psicologo')
            ->join('pacientes', 'pacientes.id_paciente = historial_asignaciones.id_paciente')
            ->where('historial_asignaciones.id_psicologo', $id_psicologo)
            ->where('historial_asignaciones.estatus_asignacion', 1) // Solo asignaciones activas
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
            ->join('alumnos', 'alumnos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('invitados', 'invitados.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('administrativos', 'administrativos.id_paciente = historial_asignaciones.id_paciente', 'left') // Usa LEFT JOIN si los datos no siempre están presentes
            ->join('usuarios', 'usuarios.id_usuario = historial_asignaciones.id_paciente')
            ->join('pacientes', 'pacientes.id_paciente = historial_asignaciones.id_paciente')
            ->where('historial_asignaciones.id_paciente', $id_paciente)
            ->first();

        return $resultado;
    }

}//End Model roles