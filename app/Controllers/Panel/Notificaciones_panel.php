<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Models\Tabla_notificaciones;

class Notificaciones_panel extends BaseController{
	
    public function marcar_como_leido()
    {
        $request = \Config\Services::request();
        $data = $request->getJSON();

        if (!isset($data->id)) {
            return $this->response->setJSON(['success' => false]);
        }

        $notificacionesModel = new Tabla_notificaciones();
        $result = $notificacionesModel->marcar_como_leido($data->id);

        return $this->response->setJSON(['success' => $result]);
    }

}//End Class Dashboard
