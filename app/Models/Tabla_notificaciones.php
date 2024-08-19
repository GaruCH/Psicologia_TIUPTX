<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_notificaciones extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $allowedFields = ['id_usuario', 'tipo_notificacion', 'titulo_notificacion', 'mensaje', 'leida'];

    protected $useTimestamps = true;
    protected $createdField = 'creacion';
    protected $updatedField = 'actualizacion';
    protected $deletedField = 'eliminacion';

    public function obtener_notificacion_usuario($userId)
    {
        return $this->select('
        notificaciones.id_notificacion, 
    notificaciones.titulo_notificacion, 
    notificaciones.tipo_notificacion, 
    notificaciones.mensaje, 
    notificaciones.leida, 
    notificaciones.creacion AS fecha, 
    roles.rol
        ')
            ->join('usuarios', 'usuarios.id_usuario = notificaciones.id_usuario')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('notificaciones.id_usuario', $userId)
            ->where('leida', ESTATUS_NO_LEIDA) // Añadido para filtrar notificaciones no leídas
            ->findAll();
    }


    public function marcar_como_leido($notificationId)
    {
        return $this->update($notificationId, ['leida' => ESTATUS_LEIDA]);
    }
}
