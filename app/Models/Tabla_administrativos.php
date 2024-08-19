<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_administrativos extends Model
{
    protected $table      = 'administrativos';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente','numero_trabajador_administrativo', 'id_area', 'eliminacion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    
    
    public function existe_numero_trabajador_administrativo($numero_trabajador_administrativo = NULL)
    {
        $resultado = $this
            ->select('numero_trabajador_administrativo, eliminacion')
            ->where('numero_trabajador_administrativo', $numero_trabajador_administrativo)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } //end if numero de trabajador no eliminado
            else {
                $opcion = -100;
            } //end else
        } //end if existe registro

        return $opcion;
    } //end existe numero de trabajador

    public function obtener_administrativo($id_paciente = 0)
    {
        $resultado = $this
            ->select('numero_trabajador_administrativo, id_area')
            ->where('id_paciente', $id_paciente)
            ->first();

            return $resultado;
    }

}//End Model dias