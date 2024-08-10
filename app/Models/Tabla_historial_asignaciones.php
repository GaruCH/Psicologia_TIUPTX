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

    public function datatable_historial_asignaciones()
    {
        // Ajusta la consulta para obtener los historiales
        $resultado = $this
            ->select('historial_asignaciones.id_historial, usuarios.nombre_usuario AS nombre_paciente, psicologos.nombre_usuario AS nombre_psicologo, historial_asignaciones.fecha_asignacion, historial_asignaciones.descripcion')
            ->join('usuarios', 'usuarios.id_usuario = historial_asignaciones.id_paciente')
            ->join('usuarios AS psicologos', 'psicologos.id_usuario = historial_asignaciones.id_psicologo')
            ->orderBy('historial_asignaciones.fecha_asignacion', 'ASC')
            ->findAll();

        $historiales = array();
        foreach ($resultado as $res) {
            $historiales[] = [
                'id_historial' => $res->id_historial,
                'nombre_paciente' => $res->nombre_paciente,
                'nombre_psicologo' => $res->nombre_psicologo,
                'fecha_asignacion' => $res->fecha_asignacion,
                'descripcion' => $res->descripcion
            ];
        } //end foreach resultado

        return $historiales;
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
    public function obtener_paciente_asignado($id_paciente = 0){

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