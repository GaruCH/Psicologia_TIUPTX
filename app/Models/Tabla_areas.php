<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_areas extends Model
{
    protected $table      = 'areas';
    protected $primaryKey = 'id_area';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_dia', 'id_area', 'nombre_area'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_areas()
    {
        $resultado = $this
            ->select('id_area AS clave, nombre_area AS nombre')
            ->orderBy('id_area', 'ASC')
            ->findAll();

        $areas = array();
        foreach ($resultado as $res) {
            $areas[$res->clave] = $res->nombre;
        } //end foreach resultado
        return $areas;
    } //end obtener_dias

}//End Model dias