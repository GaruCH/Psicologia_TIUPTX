<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Tabla_horarios extends Model
{
    protected $table      = 'horarios_psicologos';
    protected $primaryKey = 'id_horario';
    protected $returnType = 'object';
    protected $allowedFields = [
        'estatus_horario', 'id_horario', 'id_psicologo', 'id_dia', 'turno_entrada', 'turno_salida', 'eliminacion'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function datatable_horarios($id_usuario_actual = 0, $rol_actual = 0)
    {

        if ($rol_actual == ROL_PSICOLOGO['clave']) {
            $resultado = $this
                ->select('estatus_horario,id_horario, id_psicologo, id_dia, turno_entrada, turno_salida')
                ->where('id_psicologo', $id_usuario_actual) 
                ->orderBy('id_dia', 'ASC')
                ->findAll();
            return $resultado;
        }
    } //end datatable_horarios

    public function horarioExists($id_psicologo, $id_dia)
    {
        $resultado = $this
            ->where('id_psicologo', $id_psicologo)
            ->where('id_dia', $id_dia)
            ->first();
        return $resultado;
    }
}//End Model Horarios
