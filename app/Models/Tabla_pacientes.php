<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_pacientes extends Model
{
    protected $table      = 'pacientes';
    protected $primaryKey = 'id_paciente';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_paciente',
        'id_tipo_referencia',
        'id_tipo_atencion',
        'observaciones',
        'numero_expediente',
        'id_subcate'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';


    public function generar_expediente()
    {
        // Obtener una instancia del Query Builder
        $builder = $this->builder();

        // Obtener el año actual
        $anio_actual = date('Y');

        // Construir la consulta usando Query Builder
        $builder->select('numero_expediente');
        $builder->like('numero_expediente', "SP%-{$anio_actual}");
        $builder->orderBy('numero_expediente', 'DESC');
        $builder->limit(1);

        // Ejecutar la consulta
        $ultimo_expediente = $builder->get()->getRow();

        // Lógica para generar el nuevo expediente
        if ($ultimo_expediente) {
            $ultimo_numero = intval(substr($ultimo_expediente->numero_expediente, 2, 3)) + 1;
        } else {
            $ultimo_numero = 1;
        }

        // Formatear el número con ceros a la izquierda
        $contador_formateado = str_pad($ultimo_numero, 3, '0', STR_PAD_LEFT);

        // Retornar el nuevo número de expediente
        return "SP{$contador_formateado}-{$anio_actual}";
    }

    public function obtener_paciente($id_paciente = 0)
    {
        $resultado = $this
            ->select('
            u.id_usuario,
            u.nombre_usuario,
            u.ap_paterno_usuario,
            u.ap_materno_usuario
        ')
            ->join('usuarios u', 'u.id_usuario = pacientes.id_paciente') // Asegúrate de usar un alias para la tabla
            ->where('pacientes.id_paciente', $id_paciente)
            ->first();

        return $resultado;
    }
}//End Model usuarios