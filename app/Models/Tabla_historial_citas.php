<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Tabla_historial_citas extends Model
{
    protected $table      = 'historial_citas';
    protected $primaryKey = 'id_historial_cita';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_historial_cita',
        'id_cita',
        'estatus_anterior',
        'nuevo_estatus',
        'fecha_historial',
        'descripcion'
    ];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

}
