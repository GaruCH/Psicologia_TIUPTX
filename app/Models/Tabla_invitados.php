<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_invitados extends Model
{
    protected $table      = 'invitados';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente', 'identificador'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    
}//End Model dias