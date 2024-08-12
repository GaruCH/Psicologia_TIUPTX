<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_alumnos extends Model
{
    protected $table      = 'alumnos';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente','matricula', 'id_programa', 'eliminacion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function existe_matricula($matricula = NULL)
    {
        $resultado = $this
            ->select('matricula, eliminacion')
            ->where('matricula', $matricula)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } //end if matricula no eliminada
            else {
                $opcion = -100;
            } //end else
        } //end if existe registro

        return $opcion;
    } //end existe_matricula


}//End Model Alumnos