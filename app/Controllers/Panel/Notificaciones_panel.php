<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\Tabla_notificaciones;
use App\Libraries\Permisos;

class Notificaciones_panel extends BaseController
{

    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_NOTIFICACIONES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol no permitido
        else {
            $session->tarea_actual = TAREA_NOTIFICACIONES;
        } //end else rol permitido
    } //end constructor

    public function marcar_como_leido()
    {
        if ($this->permitido) {
            $request = \Config\Services::request();
            $data = $request->getJSON();

            if (!isset($data->id)) {
                return $this->response->setJSON(['success' => false]);
            }

            $notificacionesModel = new Tabla_notificaciones();
            $result = $notificacionesModel->marcar_como_leido($data->id);

            return $this->response->setJSON(['success' => $result]);
        } else {
            mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
            return redirect()->to(route_to('login'));
        }
    }
}//End Class Dashboard
