<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_historial_asignaciones extends Model
{
    protected $table      = 'historial_asignaciones';
    protected $primaryKey = 'id_historial';
    protected $returnType = 'object';
    protected $allowedFields = [ 'id_historial', 'id_paciente', 'id_psicologo', 'fecha_asignacion', 'descripcion'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_historial_asignaciones()
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


}//End Model roles