<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_pacientes extends Model
{
    protected $table      = 'pacientes';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_paciente','id_tipo_referencia', 'id_tipo_atencion', 'observaciones', 'numero_expediente', 'id_subcate'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_ultimo_expediente()
    {
        $añoActual = date('Y');
        $builder = $this->builder();
        $builder->select('*');
        $builder->like('numero_expediente', "EXP-$añoActual%");
        $builder->where('eliminacion', null);
        $builder->orderBy('numero_expediente', 'DESC');
        $builder->limit(1);
        
        $sql = $builder->getCompiledSelect();
        log_message('debug', 'SQL: ' . $sql); // Añadir esta línea para registrar la consulta SQL
        
        return $builder->get()->getRow();
    }

}//End Model usuarios