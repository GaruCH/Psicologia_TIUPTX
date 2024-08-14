<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_historial_asignaciones extends Model
{
    protected $table      = 'historial_asignaciones';
    protected $primaryKey = 'id_historial';
    protected $returnType = 'object';
    protected $allowedFields = ['id_historial', 'id_asignacion', 'estatus_anterior', 'nuevo_estatus','fecha_historial', 'descripcion'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;



}//End Model roles