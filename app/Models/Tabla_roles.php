<?php namespace App\Models;

use CodeIgniter\Model;

class Tabla_roles extends Model{
    protected $table      = 'roles';
    protected $primaryKey = 'id_rol';
    protected $returnType = 'object';
    protected $allowedFields = ['estatus_rol', 'id_rol', 'rol'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function obtener_roles($rol_actual = 0){
        if($rol_actual == ROL_SUPERADMIN['clave']){
            $resultado = $this
                        ->select('id_rol AS clave, rol AS nombre')
                        ->orderBy('rol', 'ASC')
                        ->findAll();
        }//end if el rol actual es el superadmin
        else{
            $resultado = $this
                        ->select('id_rol AS clave, rol AS nombre')
                        ->where('id_rol != ', ROL_ADMIN['clave'])
                        ->where('id_rol != ', ROL_SUPERADMIN['clave'])
                        ->orderBy('rol', 'ASC')
                        ->findAll();
        }//end else el rol actual es el superadmin
        $roles = array();
        foreach($resultado as $res){
            $roles[$res->clave] = $res->nombre;
        }//end foreach resultado
        return $roles;
    }//end obtener_roles

}//End Model roles
