<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_administrativos extends Model
{
    protected $table      = 'administrativos';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente','numero_trabajador_administrativo', 'id_area'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    

}//End Model dias