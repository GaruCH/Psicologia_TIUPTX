<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_dias extends Model
{
    protected $table      = 'dias';
    protected $primaryKey = 'id_dia';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_dia', 'id_dia', 'nombre_dia'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_dias()
    {
        $resultado = $this
            ->select('id_dia AS clave, nombre_dia AS nombre')
            ->orderBy('id_dia', 'ASC')
            ->findAll();

        $dias = array();
        foreach ($resultado as $res) {
            $dias[$res->clave] = $res->nombre;
        } //end foreach resultado
        return $dias;
    } //end obtener_dias

}//End Model dias