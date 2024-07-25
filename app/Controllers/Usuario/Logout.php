<?php namespace App\Controllers\Usuario;
use App\Controllers\BaseController;

class Logout extends BaseController{

	public function index(){
		$nombre = session()->nombre_perfil;
		session()->destroy();
		mensaje("", INFO_ALERT, "¡Hasta Pronto ".$nombre."!");
		return redirect()->to(route_to('login'));
	}//end index

}//End Class Logout
