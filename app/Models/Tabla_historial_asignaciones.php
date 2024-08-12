<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_historial_asignaciones extends Model
{
    protected $table      = 'historial_asignaciones';
    protected $primaryKey = 'id_historial';
    protected $returnType = 'object';
    protected $allowedFields = ['id_historial', 'id_asignacion', 'id_paciente', 'id_psicologo', 'estatus_asignacion', 'fecha_historial', 'descripcion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';



}//End Model roles