<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_tipos_referencias extends Model
{
    protected $table      = 'tipos_referencias';
    protected $primaryKey = 'id_tipo_referencia';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_tipo_referencia', 'id_tipo_referencia', 'tipo_referencia'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_tipos_referencias()
    {
            $resultado = $this
                ->select('id_tipo_referencia AS clave, tipo_referencia AS nombre')
                ->orderBy('tipo_referencia', 'ASC')
                ->findAll();

        $referencias = array();
        foreach ($resultado as $res) {
            $referencias[$res->clave] = $res->nombre;
        } //end foreach resultado
        return $referencias;
    } //end obtener_roles

}//End Model roles