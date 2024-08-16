<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_programas_educativos extends Model
{
    protected $table      = 'programas_educativos';
    protected $primaryKey = 'id_programa';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_programa', 'id_programa', 'nombre_programa'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_programas_educativos()
    {
        $resultado = $this
            ->select('id_programa AS clave, nombre_programa AS nombre')
            ->orderBy('nombre_programa', 'ASC')
            ->findAll();

        $carreras = array();
        foreach ($resultado as $res) {
            $carreras[$res->clave] = $res->nombre;
        } //end foreach resultado
        return $carreras;
    } //end obtener_roles

    public function obtener_programa_educativo($id_programa = 0)
    {
        $resultado = $this
            ->select('nombre_programa')
            ->where('id_programa', $id_programa)
            ->first();

            return $resultado;
    }
}//End Model roles