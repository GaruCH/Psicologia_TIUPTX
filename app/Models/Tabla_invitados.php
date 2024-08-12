<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_invitados extends Model
{
    protected $table      = 'invitados';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = ['id_paciente', 'identificador', 'eliminacion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    
    public function existe_identificador($identificador = NULL)
    {
        $resultado = $this
            ->select('identificador, eliminacion')
            ->where('identificador', $identificador)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } //end if identificador no eliminado
            else {
                $opcion = -100;
            } //end else
        } //end if existe registro

        return $opcion;
    } //end existe_identificador


}//End Model dias