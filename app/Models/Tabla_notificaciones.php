<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_notificaciones extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $allowedFields = ['id_usuario', 'tipo_notificacion', 'titulo_notificacion', 'mensaje','ruta', 'leida'];

    protected $useTimestamps = true;
    protected $createdField = 'creacion';
    protected $updatedField = 'actualizacion';
    protected $deletedField = 'eliminacion';

    public function obtener_notificacion_usuario($userId)
    {
        return $this->select('id_notificacion, titulo_notificacion, tipo_notificacion, mensaje, leida, creacion as fecha, ruta')
            ->where('id_usuario', $userId)
            ->where('leida', ESTATUS_NO_LEIDA) // Añadido para filtrar notificaciones no leídas
            ->findAll();
    }


    public function marcar_como_leido($notificationId)
    {
        return $this->update($notificationId, ['leida' => ESTATUS_LEIDA]);
    }
}
