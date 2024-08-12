<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Tabla_usuarios extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'object';
    protected $allowedFields = [
        'estatus_usuario', 'id_usuario', 'nombre_usuario', 'ap_paterno_usuario',
        'ap_materno_usuario', 'sexo_usuario', 'fecha_nacimiento_usuario', 'email_usuario', 'password_usuario',
        'imagen_usuario', 'reset_token', 'reset_expires', 'id_rol', 'eliminacion'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

    public function login($email = NULL, $password = NULL)
    {
        $resultado = $this
            ->select('estatus_usuario, id_usuario, nombre_usuario, ap_paterno_usuario,
                    ap_materno_usuario, sexo_usuario, email_usuario, imagen_usuario,
                    usuarios.id_rol AS clave_rol, roles.rol AS nombre_rol')
            ->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('email_usuario', $email)
            ->where('password_usuario', $password)  // Asegúrate de estar usando una función hash para la contraseña
            ->first();
        return $resultado;
    } //end login

    public function datatable_usuarios($id_usuario_actual = 0, $rol_actual = 0)
    {
        if ($rol_actual == ROL_SUPERADMIN['clave']) {
            $resultado = $this
                ->select('id_usuario, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                            sexo_usuario, email_usuario, imagen_usuario, rol, usuarios.eliminacion')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('id_usuario !=', $id_usuario_actual)
                ->orderBy('nombre_usuario', 'ASC')
                ->withDeleted()
                ->findAll();

            return $resultado;
        } //end if el rol actual es superadmin
        else {
            $resultado = $this
                ->select('id_usuario, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                            sexo_usuario, email_usuario, imagen_usuario, rol')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('id_usuario !=', $id_usuario_actual)
                ->where('roles.id_rol !=', ROL_SUPERADMIN['clave'])
                ->where('roles.id_rol !=', ROL_ADMIN['clave'])
                ->orderBy('nombre_usuario', 'ASC')
                ->findAll();

            return $resultado;
        } //end else el rol actual es superadmin

    } //end datatable_usuarios

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


    public function obtener_usuario($id_usuario = 0)
    {
        $resultado = $this
            ->select('id_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                            sexo_usuario, email_usuario, fecha_nacimiento_usuario, imagen_usuario, id_rol')
            ->where('id_usuario', $id_usuario)
            ->first();
        return $resultado;
    } //end obtener_usuario

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

    public function obtener_contraseña($email = NULL)
    {

        $resultado = $this
            ->select('password_usuario, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, email_usuario')
            ->where('email_usuario', $email)
            ->first();

        return $resultado;
    }

    // Función para generar un token de restablecimiento
    public function generateResetToken($email)
    {
        $user = $this->where('email_usuario', $email)->first();
        if ($user) {
            $token = bin2hex(random_bytes(50));
            $this->update($user->id_usuario, [
                'reset_token' => $token,
                'reset_expires' => Time::now()->addMinutes(30) // Token válido por 30 minutos
            ]);
            return $token;
        }
        return false;
    }

    // Función para obtener un usuario por su token de restablecimiento
    public function getUserByResetToken($token)
    {
        return $this->where('reset_token', $token)
            ->where('reset_expires >=', Time::now())
            ->first();
    }

    // Función para restablecer la contraseña
    public function resetPassword($token, $password)
    {
        $user = $this->getUserByResetToken($token);
        if ($user) {
            $this->update($user->id_usuario, [
                'password_usuario' => $password,
                'reset_token' => null,
                'reset_expires' => null
            ]);
            return true;
        }
        return false;
    }

    public function obtener_psicologos_activos()
    {
        $resultado = $this
            ->select('id_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, numero_trabajador_psicologo')
            ->join('psicologos p', 'id_usuario = p.id_psicologo')
            ->where('estatus_usuario', ESTATUS_HABILITADO)
            ->findAll();

        return $resultado;
    }
}//End Model usuarios
