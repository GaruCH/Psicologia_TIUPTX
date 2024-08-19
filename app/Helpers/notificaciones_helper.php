<?php

use App\Models\Tabla_notificaciones;

if (!function_exists('cargar_notificaciones')) {
    function cargar_notificaciones()
    {
        $session = session();
       

        $notificacionesModel = new Tabla_notificaciones();
        return $notificacionesModel->obtener_notificacion_usuario($session->id_usuario);
    }
}

if (!function_exists('crear_notificacion')) {
    function crear_notificacion($datos)
    {
        $notificacionesModel = new Tabla_notificaciones();
        return $notificacionesModel->insert($datos);
    }
}

