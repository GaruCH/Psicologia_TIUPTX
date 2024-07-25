<?php namespace App\Controllers\Db;
use App\Controllers\BaseController;

class Config extends BaseController{

    public function __construct(){
        set_time_limit(5000);
    }//end constructor

    public function first_time(){
        $configs_database = db_connect();
        $cargar_db = new \App\Models\Cargar_db;
        $cargar_db->config_first_time($configs_database->database, $configs_database->username, $configs_database->password);
        $cargar_db->importar($configs_database->database);
    }//end first_time

    public function clear(){
        $configs_database = \Config\Database::connect();
        $cargar_db = new \App\Models\Cargar_db;
        $cargar_db->importar($configs_database->database);
    }//end clear

	public function index(){
		return null;
	}//end index

	private function crear_vista($nombre_vista,$datos = null){
		return null;
	}//end crear_vista

}//End class Config
