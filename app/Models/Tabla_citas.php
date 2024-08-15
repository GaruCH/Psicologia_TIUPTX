<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Tabla_citas extends Model
{
    protected $table      = 'citas';
    protected $primaryKey = 'id_cita';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_cita',
        'id_paciente',
        'id_psicologo',
        'fecha_cita',
        'hora_cita',
        'descripcion_cita',
        'estatus_cita',
        'fecha_creacion',
        'fecha_actualizacion'
    ];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    public function datatable_citas($id_psicologo_actual = 0)
    {
        $resultado = $this
            ->select('
            citas.id_cita,
            citas.fecha_cita,
            citas.hora_cita, 
            citas.descripcion_cita,
            citas.estatus_cita,
            paciente.nombre_usuario as nombre_paciente,
            paciente.ap_paterno_usuario as ap_paterno_paciente,
            paciente.ap_materno_usuario as ap_materno_paciente,
            pacientes.id_subcate,
            alumnos.matricula,
            administrativos.numero_trabajador_administrativo,
            invitados.identificador,
            ')
            ->join('alumnos', 'alumnos.id_paciente = citas.id_paciente', 'left')
            ->join('invitados', 'invitados.id_paciente = citas.id_paciente', 'left')
            ->join('administrativos', 'administrativos.id_paciente = citas.id_paciente', 'left')
            ->join('pacientes', 'pacientes.id_paciente = citas.id_paciente')
            ->join('usuarios as paciente', 'paciente.id_usuario = citas.id_paciente')
            ->where('citas.id_psicologo', $id_psicologo_actual)
            ->whereIn('citas.estatus_cita', [ESTATUS_PENDIENTE, ESTATUS_CONFIRMADA]) // Solo obtener citas 'Pendientes' o 'Confirmadas'
            ->orderBy('paciente.nombre_usuario', 'ASC')
            ->findAll();
        return $resultado;
    }

    public function obtenerHorasOcupadas($id_psicologo, $fecha)
    {
        $resultado = $this
            ->select('hora_cita')
            ->where('id_psicologo', $id_psicologo)
            ->where('DATE(fecha_cita)', $fecha)
            ->whereIn('estatus_cita', [ESTATUS_PENDIENTE, ESTATUS_CONFIRMADA])
            ->findAll();

        return $resultado;
    }


    public function datatable_historial_citas($id_psicologo = 0)
    {

        $resultado = $this
            ->select(
                '
            citas.id_cita,
            paciente.nombre_usuario as nombre_paciente,
            paciente.ap_paterno_usuario as ap_paterno_paciente,
            paciente.ap_materno_usuario as ap_materno_paciente,
            pacientes.id_subcate,
            alumnos.matricula,
            administrativos.numero_trabajador_administrativo,
            invitados.identificador,
            historial_citas.nuevo_estatus,
            historial_citas.fecha_historial,
            historial_citas.descripcion
            '
            )
            ->join('alumnos', 'alumnos.id_paciente = citas.id_paciente', 'left')
            ->join('invitados', 'invitados.id_paciente = citas.id_paciente', 'left')
            ->join('administrativos', 'administrativos.id_paciente = citas.id_paciente', 'left')
            ->join('pacientes', 'pacientes.id_paciente = citas.id_paciente')
            ->join('usuarios as paciente', 'paciente.id_usuario = citas.id_paciente')
            ->join('historial_citas', ' historial_citas.id_cita = citas.id_cita')
            ->where('citas.id_psicologo', $id_psicologo)
            ->orderBy('paciente.nombre_usuario', 'ASC')
            ->findAll();
        return $resultado;
    }

    public function datatable_citas_paciente($id_paciente_actual = 0)
    {
        $resultado = $this
            ->select('
            citas.id_cita,
            citas.fecha_cita,
            citas.hora_cita, 
            citas.descripcion_cita,
            citas.estatus_cita,
            psicologo.nombre_usuario as nombre_psicologo,
            psicologo.ap_paterno_usuario as ap_paterno_psicologo,
            psicologo.ap_materno_usuario as ap_materno_psicologo,
            ')
            ->join('psicologos', 'psicologos.id_psicologo = citas.id_psicologo')
            ->join('usuarios as psicologo', 'psicologo.id_usuario = citas.id_psicologo')
            ->where('citas.id_paciente', $id_paciente_actual)
            ->whereIn('citas.estatus_cita', [ESTATUS_PENDIENTE, ESTATUS_CONFIRMADA]) // Solo obtener citas 'Pendientes' o 'Confirmadas'
            ->orderBy('psicologo.nombre_usuario', 'ASC')
            ->findAll();
        return $resultado;
    }

    public function obtener_cita($id_cita)
    {
        return $this->select('
            citas.id_psicologo,
            citas.id_paciente,
            citas.fecha_cita,
            citas.hora_cita, 
            citas.descripcion_cita,
            citas.estatus_cita,
        ')
            ->where('citas.id_cita', $id_cita)
            ->first();
    }

    public function datatable_historial_citas_paciente($id_paciente = 0)
    {

        $resultado = $this
            ->select(
                '
            citas.id_cita,
            psicologo.nombre_usuario as nombre_psicologo,
            psicologo.ap_paterno_usuario as ap_paterno_psicologo,
            psicologo.ap_materno_usuario as ap_materno_psicologo,
            historial_citas.nuevo_estatus,
            historial_citas.fecha_historial,
            historial_citas.descripcion
            '
            )
            ->join('psicologos', 'psicologos.id_psicologo = citas.id_psicologo')
            ->join('usuarios as psicologo', 'psicologo.id_usuario = citas.id_psicologo')
            ->join('historial_citas', ' historial_citas.id_cita = citas.id_cita')
            ->where('citas.id_paciente', $id_paciente)
            ->orderBy('psicologo.nombre_usuario', 'ASC')
            ->findAll();
        return $resultado;
    }
}
