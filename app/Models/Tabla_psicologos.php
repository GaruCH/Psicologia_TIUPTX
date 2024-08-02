<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Tabla_psicologos extends Model
{
    protected $table      = 'psicologos';
    protected $primaryKey = 'id_psicologo';
    protected $returnType = 'object';
    protected $allowedFields = [
         'id_psicologo', 'numero_trabajador_psicologo', 'eliminacion'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function datatable_psicologos($id_usuario_actual = 0, $rol_actual = 0)
    {
        if ($rol_actual == ROL_SUPERADMIN['clave']) {
            $resultado = $this
                ->select('id_psicologo, numero_trabajador_psicologo, psicologos.eliminacion,
                          estatus_usuario ,nombre_usuario,ap_paterno_usuario, ap_materno_usuario,
                          sexo_usuario, email_usuario, fecha_nacimiento_usuario, imagen_usuario')
                ->join('usuarios', 'psicologos.id_psicologo = usuarios.id_usuario')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('roles.id_rol', ROL_PSICOLOGO['clave'])
                ->where('usuarios.id_usuario !=', $id_usuario_actual)
                ->orderBy('nombre_usuario', 'ASC')
                ->withDeleted()  // Si necesitas incluir registros eliminados
                ->findAll();

            return $resultado;
        } //end if el rol actual es superadmin
        elseif ($rol_actual == ROL_ADMIN['clave']) {
            $resultado = $this
                ->select('id_psicologo, numero_trabajador_psicologo, estatus_usuario,
                          nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                          sexo_usuario, email_usuario, fecha_nacimiento_usuario, imagen_usuario')
                ->join('usuarios', 'psicologos.id_psicologo = usuarios.id_usuario')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('roles.id_rol', ROL_PSICOLOGO['clave'])  // Asegúrate de que esta constante exista y sea correcta
                ->where('usuarios.id_usuario !=', $id_usuario_actual)
                ->orderBy('nombre_usuario', 'ASC')
                ->findAll();

            return $resultado;
        }
    } //end datatable_psicologos



    public function existe_email($email = NULL)
    {
        $resultado = $this
            ->select('email_usuario, eliminacion')
            ->where('email_usuario', $email)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } //end if email no eliminado
            else {
                $opcion = -100;
            } //end else
        } //end if existe registro

        return $opcion;
    } //end existe_email

    public function obtener_psicologo($id_psicologo = 0)
    {
        $resultado = $this
            ->select('id_psicologo, numero_trabajador_psicologo, 
                 nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                  sexo_usuario, email_usuario, fecha_nacimiento_usuario, imagen_usuario
                  ')
            ->join('usuarios', 'psicologos.id_psicologo = usuarios.id_usuario')
            ->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('usuarios.id_usuario', $id_psicologo)
            ->where('roles.id_rol', ROL_PSICOLOGO['clave']) 
            ->first();
        return $resultado;
    } //end obtener_psicologo


    public function existe_email_excepto_actual($email = NULL, $id_usuario = 0)
    {
        $resultado = $this
            ->select('id_usuario, email_usuario, eliminacion')
            ->where('email_usuario', $email)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->id_usuario == $id_usuario) {
                $opcion = -1;
            } //end if usuario encontrado es el actual
            else {
                if ($resultado->eliminacion == null) {
                    $opcion = 2;
                } //end if email no eliminado
                else {
                    $opcion = -100;
                } //end else
            } //end else usuario encontrado es el actual
        } //end if existe registro

        return $opcion;
    } //end existe_email_excepto_actual

}//End Model psicologos
