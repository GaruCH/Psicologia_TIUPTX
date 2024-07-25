<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_pacientes extends Model
{
    protected $table      = 'paciente';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = [
        'estatus_paciente', 'id_paciente', 'referencia',
        'tipo_atencion', 'observaciones', 'numero_expediente', 'id_subcate'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    }//End Model usuarios