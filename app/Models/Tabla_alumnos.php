<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_alumnos extends Model
{
    protected $table      = 'alumnos';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente','matricula', 'id_programa'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    

}//End Model dias