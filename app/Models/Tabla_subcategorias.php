<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_subcategorias extends Model
{
    protected $table      = 'subcategorias';
    protected $primaryKey = 'id_subcate';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_subcate', 'id_subcate', 'subcategoria'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_subcategorias()
    {
            $resultado = $this
                ->select('id_subcate AS clave, subcategoria AS nombre')
                ->orderBy('subcategoria', 'ASC')
                ->findAll();

        $subcategorias = array();
        foreach ($resultado as $res) {
            $subcategorias[$res->clave] = $res->nombre;
        } //end foreach resultado
        return $subcategorias;
    } //end obtener_roles

}//End Model roles