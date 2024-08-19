<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Psicologos extends BaseController
{
    private $permitido = true;

    public function __construct()
    {
        $session = session();
        if (!Permisos::is_rol_permitido(TAREA_ADMIN_PSICOLOGOS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
            $this->permitido = false;
        } //end if rol permitido
        else {
            $session->tarea_actual = TAREA_ADMIN_PSICOLOGOS;
        } //end else rol permitido
    } //end constructor

    public function index()
    {
        if ($this->permitido) {
            return $this->crear_vista("panel/psicologos", $this->cargar_datos());
        } //end if rol permitido
        else {
            mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
            return redirect()->to(route_to('login'));
        } //end else rol no permitido
    } //end index

    private function cargar_datos()
    {
        //======================================================================
        //==========================DATOS FUNDAMENTALES=========================
        //======================================================================



        $datos = array();
        $session = session();
        $datos['nombre_completo_usuario'] = $session->nombre_completo_usuario;
        $datos['email_usuario'] = $session->email_usuario;
        $datos['imagen_usuario'] = ($session->imagen_usuario == NULL ?
            ($session->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') :
            $session->imagen_usuario);



        //======================================================================
        //========================DATOS PROPIOS CONTROLLER======================
        //======================================================================



        $datos['nombre_pagina'] = 'Administración Psicólogos';

        //Breadcrumb
        $navegacion = array(
            array(
                'tarea' => 'Psicólogos',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Psicólogos');

        // Cargar notificaciones utilizando el helper
        $datos['notificaciones'] = cargar_notificaciones(); // Utiliza la función del helper

        return $datos;
    } //end cargar_datos

    private function crear_vista($nombre_vista, $contenido = array())
    {
        $session = session();

		$perfil = cargarPerfilUsuario($session);

		// Combinar el contenido existente con el perfil de usuario
		$contenido = array_merge($contenido, $perfil);
        
        $contenido['menu'] = crear_menu_panel();
        return view($nombre_vista, $contenido);
    } //end crear_vista



    //======================================================================
    //========================SECCIÓN PARA DATATABLE========================
    //======================================================================



    public function generar_datatable_psicologos()
    {
        if ($this->permitido) {
            $session = session();
            $tabla_psicologos = new \App\Models\Tabla_psicologos;
            $psicologos = $tabla_psicologos->datatable_psicologos($session->id_usuario, $session->rol_actual['clave']);
            $data = array();
            $count = 0;
            foreach ($psicologos as $psicologo) {
                $sub_array = array();
                $acciones = '';
                $sub_array['total'] = ++$count;
                $sub_array['numero_trabajador'] = $psicologo->numero_trabajador_psicologo;
                $sub_array['nombre_psicologo'] = $psicologo->nombre_usuario . ' ' . $psicologo->ap_paterno_usuario . ' ' . $psicologo->ap_materno_usuario;
                if ($psicologo->sexo_usuario == SEXO_MASCULINO) {
                    $sub_array['sexo_psicologo'] = 'Hombre';
                } else {
                    $sub_array['sexo_psicologo'] = 'Mujer';
                }

                $sub_array['edad_psicologo'] = calcular_edad_persona($psicologo->fecha_nacimiento_usuario);
                $sub_array['correo_psicologo'] = $psicologo->email_usuario;
                if (isset($psicologo->eliminacion)) {
                    $acciones .= '<button type="button" class="btn btn-light-danger text-danger recover-psicologo btn-circle" id="recover-psicologo_' . $psicologo->id_psicologo . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Recuperar el psicólogo">
                    							<i data-feather="rotate-ccw" class="feather fill-white"></i>
                    						  </button>';
                } //end if es un psicologo eliminado
                else {
                    if (($psicologo->estatus_usuario) == ESTATUS_HABILITADO)
                        $acciones .= '<button type="button" class="btn btn-success estatus-psicologo btn-circle" id="' . $psicologo->id_psicologo . '_' . $psicologo->estatus_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar al psicólogo">
                                                        <i data-feather="toggle-right" class="feather fill-white"></i>
                                                  </button>';
                    else
                        $acciones .= '<button type="button" class="btn btn-secondary estatus-psicologo btn-circle" id="' . $psicologo->id_psicologo . '_' . $psicologo->estatus_usuario . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar al psicólogo">
                                                        <i data-feather="toggle-left" class="feather fill-white"></i>
                                                  </button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                    $acciones .=  '<button type="button" class="btn btn-warning editar-psicologo btn-circle" id="editar-psicologo_' . $psicologo->id_psicologo . '" data-bs-toggle="tooltip" data-bs-target="#editar-psicologo" data-bs-placement="top" title="Editar al psicólogo">
                                                    <i data-feather="edit-3" class="feather fill-white"></i>
                                              </button>';
                    $acciones .= '&nbsp;&nbsp;&nbsp;';
                    $acciones .=  '<button type="button" class="btn btn-info cambiar-password-psicologo btn-circle" id="pass_' . $psicologo->id_psicologo . '" data-bs-toggle="tooltip" data-bs-target="#cambiar-password-psicologo" data-bs-placement="top" title="Cambiar contraseña del psicólogo">
                                                    <i data-feather="unlock" class="feather feather-sm fill-white"></i><i data-feather="rotate-ccw" class="feather feather-sm fill-white" style="width: 12px; height: 12px;"></i>
                                              </button>';
                    $acciones .=  '&nbsp;&nbsp;&nbsp;';
                    $acciones .=  '<button type="button" class="btn btn-danger eliminar-psicologo btn-circle" id="' . $psicologo->id_psicologo . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar al psicólogo">
                                                    <i data-feather="trash-2" class="feather fill-white"></i>
                                              </button>';
                } //end else es un psicologo eliminado
                $sub_array['acciones'] = $acciones;
                $data[] = $sub_array;
            } //end foreach psicologos
            return '{"data": ' . json_encode($data) . '}';
        } //end if es un usuario permitido
        else {
            return '{"data": ' . json_encode(array()) . '}';
        } //end else es un usuario permitido
    } //end generar_datatable_psicologos

    public function estatus_psicologo()
    {
        if ($this->permitido) {
            $tabla_usuarios = new \App\Models\Tabla_usuarios;
            if ($tabla_usuarios->update($this->request->getPost('id'), array('estatus_usuario' => $this->request->getPost('estatus')))) {
                return $this->response->setJSON(['error' => 0]);
            } //end if se actualiza estatus
            else {

                return $this->response->setJSON(['error' => 1]);
            } //end else
        } //end if es un psicologo permitido
        else {
            return $this->response->setJSON(['error' => 1]);
        } //end else es un psicologo permitido
    } //end estatus

    public function eliminar_psicologo()
    {
        if ($this->permitido) {
            $tabla_psicologos = new \App\Models\Tabla_psicologos;
            if ($tabla_psicologos->delete($this->request->getPost('id'))) {
                return $this->response->setJSON(['error' => 0]);
            } //end if elimina
            else {
                return $this->response->setJSON(['error' => 1]);
            } //end else
        } //end if es un psicologo permitido
        else {
            return $this->response->setJSON(['error' => 1]);
        } //end else es un psicologo permitido
    } //end eliminar

    public function recuperar_psicologo()
    {
        if ($this->permitido && (session()->rol_actual['clave'] == ROL_SUPERADMIN['clave'])) {
            $mensaje = array();
            $tabla_psicologos = new \App\Models\Tabla_psicologos();
            if ($tabla_psicologos->update($this->request->getPost('id'), array('eliminacion' => NULL))) {
                $mensaje['mensaje'] = 'El psicólogo se encuentra de nuevo en los registros de la base de datos.';
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['titulo'] = '¡Registro recuperado!';

                $acciones = array();
                $acciones[] = 'table_psicologos.ajax.reload(null,false)';
                return $this->response->setJSON(['error' => 0, 'mensaje' => $mensaje, 'actions' => $acciones]);
            } //end if se recupera el registro
            else {
                $mensaje['mensaje'] = 'Hubo un error al intentar recuperar el registro, checa tu conexión a internet o intente nuevamente, por favor.';
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['titulo'] = '¡Error al recuperar el registro!';

                $acciones = array();
                return $this->response->setJSON(['error' => -1, 'mensaje' => $mensaje, 'actions' => $acciones]);
            } //end else se recupera el registro
        } //end if es un psicologo permitido
        else {
            return $this->response->setJSON(['error' => -1, 'mensaje' => array(), 'actions' => array()]);
        } //end else es un psicologo permitido
    } //end recuperar_psicologo


    public function actualizar_password_psicologo()
    {
        try {
            if ($this->permitido) {
                $tabla_usuarios = new \App\Models\Tabla_usuarios();
                $id_psicologo = $this->request->getPost('id_psicologo_pass');
                log_message('debug', 'ID psicologo recibido: ' . $id_psicologo);

                if (empty($id_psicologo)) {
                    throw new \Exception('El ID del psicólogo es requerido.');
                }

                $usuario = [
                    'actualizacion' => fecha_actual(),
                    'password_usuario' => hash('sha256', $this->request->getPost('confirm_password_psicologo')),
                ];

                // Obtener la contraseña actual
                $actual_password_obj = $tabla_usuarios->select('password_usuario')->find($id_psicologo);
                log_message('debug', 'Resultado de la consulta de contraseña actual: ' . print_r($actual_password_obj, true));

                if (!$actual_password_obj) {
                    throw new \Exception('El psicólogo con el ID especificado no existe.');
                }

                // Acceder a la contraseña actual según el formato del resultado
                if (is_array($actual_password_obj)) {
                    $actual_password = $actual_password_obj['password_usuario'];
                } else {
                    $actual_password = $actual_password_obj->password_usuario;
                }

                if ($usuario['password_usuario'] == $actual_password) {
                    throw new \Exception('La nueva contraseña no puede ser igual a la antigua contraseña del psicólogo.');
                }

                if ($tabla_usuarios->update($id_psicologo, $usuario)) {
                    // Enviar correo de notificación
                    $usuarioConFecha = $tabla_usuarios->find($id_psicologo);

                    // Convertir a array asociativo si necesario
                    if (is_object($usuarioConFecha)) {
                        $usuarioConFecha = [
                            'nombre_usuario' => $usuarioConFecha->nombre_usuario,
                            'email_usuario' => $usuarioConFecha->email_usuario,
                            'fecha_cambio' => $usuarioConFecha->actualizacion
                        ];
                    }

                    if (!$this->enviarCorreoActualizacionPassword($usuarioConFecha)) {
                        throw new \Exception('Error al enviar el correo de confirmación.');
                    }

                    $mensaje = [
                        'mensaje' => 'La contraseña del psicólogo se ha actualizado exitosamente.',
                        'titulo' => '¡Contraseña actualizada!',
                        'error' => 0,
                        'tipo_mensaje' => SUCCESS_ALERT,
                        'timer_message' => 3500
                    ];
                } else {
                    throw new \Exception('Hubo un error al actualizar la contraseña del psicólogo. Intente de nuevo, por favor.');
                }

                return $this->response->setJSON($mensaje);
            } else {
                throw new \Exception('Permiso denegado.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en actualizar_password_psicologo: ' . $e->getMessage());
            return $this->response->setJSON([
                'mensaje' => 'Error al procesar la solicitud.',
                'titulo' => '¡Error!',
                'error' => -1,
                'tipo_mensaje' => DANGER_ALERT,
                'timer_message' => 3500
            ]);
        }
    }


    private function enviarCorreoActualizacionPassword($data)
    {
        $email = \Config\Services::email();

        if (empty($data['email_usuario'])) {
            log_message('error', 'Datos del usuario incompletos para enviar el correo.');
            return false;
        }

        // Registrar datos para depuración
        log_message('debug', 'Datos para la vista de correo: ' . print_r($data, true));

        // Validar que las variables dinámicas no estén vacías
        foreach ($data as $key => $value) {
            if (empty($value) && !is_array($value)) {
                log_message('error', "La variable '$key' está vacía.");
                return false;
            }
        }

        // Carga la vista y reemplaza las variables
        try {
            $message = view('plantilla/email_change_password', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
            return false;
        }

        $email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
        $email->setTo($data['email_usuario']);
        $email->setSubject('Notificación de Cambio de Contraseña');
        $email->setMessage($message);

        try {
            $email->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }


    //================================================================
    //===================SECCIÓN PARA CREAR===========================
    //================================================================


    private function enviarCorreoConfirmacion($usuario)
    {
        $email = \Config\Services::email();

        if (empty($usuario->email_usuario)) {
            log_message('error', 'Datos del psicologo incompletos para enviar el correo.');
            return false;
        }

        // Variables dinámicas para la plantilla
        $data = [
            'nombre_psicologo' => $usuario->nombre_usuario . ' ' . $usuario->ap_paterno_usuario . ' ' . $usuario->ap_materno_usuario,
            'rol_usuario' => ROLES[$usuario->id_rol],
            'email_usuario' => $usuario->email_usuario,
            'fecha_registro' => $usuario->creacion
        ];

        // Registrar datos para depuración
        log_message('debug', 'Datos para la vista de correo: ' . print_r($data, true));

        // Validar que las variables dinámicas no estén vacías
        foreach ($data as $key => $value) {
            if (empty($value) && !is_array($value)) {
                log_message('error', "La variable '$key' está vacía.");
                return false;
            }
        }

        // Carga la vista y reemplaza las variables
        try {
            $message = view('plantilla/email_psico', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
            return false;
        }

        $email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
        $email->setTo($usuario->email_usuario);
        $email->setSubject('Información de registro');
        $email->setMessage($message);

        try {
            $email->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }


    public function registrar_psicologo()
    {
        if ($this->permitido) {
            $mensaje = array();
            if ($this->request->getPost('sexo') == NULL) {
                $mensaje['mensaje'] = 'Debes seleccionar un sexo para el psicólogo';
                $mensaje['titulo'] = '¡No se pudo registrar!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } //end if no existe sexo seleccionado

            $tabla_usuarios = new \App\Models\Tabla_usuarios();
            $tabla_psicologos = new \App\Models\Tabla_psicologos();


            $usuario = [
                'estatus_usuario' => ESTATUS_HABILITADO,
                'nombre_usuario' => $this->request->getPost('nombre'),
                'ap_paterno_usuario' => $this->request->getPost('ap_paterno'),
                'ap_materno_usuario' => $this->request->getPost('ap_materno'),
                'sexo_usuario' => $this->request->getPost('sexo'),
                'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento'),
                'email_usuario' => $this->request->getPost('email'),
                'id_rol' => ROL_PSICOLOGO['clave'],
                'password_usuario' => hash('sha256', $this->request->getPost('confirm_password')),
            ];

            // Verificar si el correo ya existe
            $opcion = $tabla_usuarios->existe_email($usuario['email_usuario']);

            if ($opcion == 2 || $opcion == -100) {
                if ($opcion == 2) {
                    $mensaje['mensaje'] = 'El correo proporcionado ya está siendo usado por otro psicologo.';
                    $mensaje['titulo'] = '¡Correo en uso!';
                } elseif ($opcion == -100) {
                    $mensaje['mensaje'] = 'El correo proporcionado se encuentra en el histórico de correos eliminados.';
                    $mensaje['titulo'] = '¡Correo en uso!';
                }
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }



            if (!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0) {
                helper('upload_files');
                $archivo = $this->request->getFile('imagen_perfil');
                $usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
            } //end if existe imagen

            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Insertar en la tabla usuario
                $insertedUserId = $tabla_usuarios->insert($usuario);

                if (!$insertedUserId) {
                    throw new \Exception('Error al insertar usuario.');
                }

                // Datos del paciente
                $psicologoData = [
                    'id_psicologo' => $insertedUserId,
                    'numero_trabajador_psicologo' => $this->request->getPost('numero_trabajador'),
                ];

                $opcion1 = $tabla_psicologos->existe_numero_trabajador($psicologoData['numero_trabajador_psicologo']);
                if ($opcion1 == 2 || $opcion1 == -100) {
                    if ($opcion1 == 2) {
                        $mensaje['mensaje'] = 'El numero de trabajador proporcionado ya está registrado.';
                        $mensaje['titulo'] = '¡Numero de trabajador en uso!';
                    } elseif ($opcion1 == -100) {
                        $mensaje['mensaje'] = 'El numero de trabajador se encuentra en el histórico de numeros de trabajador eliminados.';
                        $mensaje['titulo'] = '¡Numero de trabajador en uso!';
                    }
                    $mensaje['error'] = 4;
                    $mensaje['tipo_mensaje'] = WARNING_ALERT;
                    $mensaje['timer_message'] = 3500;
                    return $this->response->setJSON($mensaje);
                }

                // Insertar en la tabla paciente
                $tabla_psicologos->insert($psicologoData);

                // Obtener el usuario con la fecha de registro
                $usuarioConFecha = $tabla_usuarios->find($insertedUserId);

                //Enviar correo de confirmación
                $correoEnviado = $this->enviarCorreoConfirmacion($usuarioConFecha);

                if ($correoEnviado === false) {
                    throw new \Exception('Error al enviar correo de confirmación.');
                }

                // Confirmar transacción
                $db->transCommit();

                // Mensaje de éxito
                $mensaje['mensaje'] = 'La cuenta ha sido registrada exitosamente.';
                $mensaje['titulo'] = '¡Registro exitoso!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $db->transRollback();

                $errorMessage = $e->getMessage();

                // Mostrar el mensaje de error (puedes ajustar cómo lo manejas)
                $mensaje['mensaje'] = 'Error al registrar la cuenta.';
                $mensaje['titulo'] = '¡Error al registrar!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
        } else {
            return $this->response->setJSON(['error' => -1]);
        }
    } //end registrar psicologo



    //==============================================================================
    //===================SECCIÓN PARA EDITAR========================================
    //==============================================================================



    public function obtener_datos_psicologo($id_psicologo = 0)
    {
        if ($this->permitido) {

            $tabla_psicologos = new \App\Models\Tabla_psicologos;
            $psicologo = $tabla_psicologos->obtener_psicologo($id_psicologo);

            if ($psicologo != NULL) {
                return $this->response->setJSON(['data' => $psicologo]);
            } //end if existe psicólogo 
            else {
                return $this->response->setJSON(['data' => -1]);
            } //end else
        } //end if es un usuario permitido
        else {
            return $this->response->setJSON(['data' => -1]);
        } // end else es un usuario permitido
    } //end obtener_datos_psicologo


    public function editar_psicologo()
    {
        if ($this->permitido) {
            $mensaje = array();
            if ($this->request->getPost('sexo_editar') == NULL) {
                $mensaje['mensaje'] = 'Debes seleccionar un sexo para el psicólogo';
                $mensaje['titulo'] = '¡No se pudo registrar!';
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }

            $tabla_usuarios = new \App\Models\Tabla_usuarios();
            $tabla_psicologos = new \App\Models\Tabla_psicologos();
            $id_psico = $this->request->getPost('id_psicologo_editar');

            $usuario = [
                'nombre_usuario' => $this->request->getPost('nombre_editar'),
                'ap_paterno_usuario' => $this->request->getPost('ap_paterno_editar'),
                'ap_materno_usuario' => $this->request->getPost('ap_materno_editar'),
                'sexo_usuario' => $this->request->getPost('sexo_editar'),
                'fecha_nacimiento_usuario' => $this->request->getPost('fecha_nacimiento_editar'),
                'email_usuario' => $this->request->getPost('email_editar'),
            ];

            // Verificar si el correo ya existe
            $opcion = $tabla_usuarios->existe_email_excepto_actual($usuario['email_usuario'], $id_psico);

            if ($opcion == 2 || $opcion == -100) {
                if ($opcion == 2) {
                    $mensaje['mensaje'] = 'El correo proporcionado ya está siendo usado por otro psicólogo.';
                    $mensaje['titulo'] = '¡Correo en uso!';
                } elseif ($opcion == -100) {
                    $mensaje['mensaje'] = 'El correo proporcionado se encuentra en el histórico de correos eliminados.';
                    $mensaje['titulo'] = '¡Correo en uso!';
                }
                $mensaje['error'] = 4;
                $mensaje['tipo_mensaje'] = WARNING_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }

            if (!empty($this->request->getFile('imagen_perfil_editar')) && $this->request->getFile('imagen_perfil_editar')->getSize() > 0) {
                helper('upload_files');
                $archivo = $this->request->getFile('imagen_perfil_editar');
                $usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
            }

            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                // Insertar en la tabla usuario
                $tabla_usuarios->update($id_psico, $usuario);

                // Actualizar psicólogo
                $psicologoData = [
                    'numero_trabajador_psicologo' => $this->request->getPost('numero_trabajador_editar')
                ];

                $updatePsicologo = $tabla_psicologos->update($id_psico, $psicologoData);

                if (!$updatePsicologo) {
                    throw new \Exception('Error al actualizar psicólogo.');
                }

                // Obtener el usuario actualizado
                $usuarioConFecha = $tabla_usuarios->find($id_psico);

                // Convertir objeto a array
                $usuarioArray = (array)$usuarioConFecha;

                // Preparar datos para el correo
                $correoData = [
                    'nombre_usuario' => $usuarioArray['nombre_usuario'],
                    'email_usuario' => $usuarioArray['email_usuario'],
                    'fecha_actualizacion' => date('Y-m-d H:i:s'), // Fecha de actualización
                ];

                // Enviar correo de confirmación
                if (!$this->enviarCorreoActualizacion($correoData)) {
                    throw new \Exception('Error al enviar correo de confirmación.');
                }

                // Confirmar transacción
                $db->transCommit();

                // Mensaje de éxito
                $mensaje['mensaje'] = 'La cuenta ha sido actualizada exitosamente.';
                $mensaje['titulo'] = '¡Actualización exitosa!';
                $mensaje['error'] = 0;
                $mensaje['tipo_mensaje'] = SUCCESS_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $db->transRollback();

                $errorMessage = $e->getMessage();

                // Mensaje de error
                $mensaje['mensaje'] = 'Error al actualizar la cuenta. ' . $errorMessage;
                $mensaje['titulo'] = '¡Error al actualizar!';
                $mensaje['error'] = -1;
                $mensaje['tipo_mensaje'] = DANGER_ALERT;
                $mensaje['timer_message'] = 3500;
                return $this->response->setJSON($mensaje);
            }
        } else {
            return $this->response->setJSON(['error' => -1]);
        }
    }


    private function enviarCorreoActualizacion($data)
    {
        $email = \Config\Services::email();

        // Verificar que las variables necesarias están presentes
        $requiredFields = ['nombre_usuario', 'email_usuario', 'fecha_actualizacion'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                log_message('error', "La variable '$field' está vacía.");
                return false;
            }
        }

        // Registrar datos para depuración
        log_message('debug', 'Datos para la vista de correo: ' . print_r($data, true));

        // Carga la vista y reemplaza las variables
        try {
            $message = view('plantilla/email_update_psico', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al generar la vista del correo: ' . $e->getMessage());
            return false;
        }

        $email->setFrom('psicologiatiamlab@gmail.com', 'Área de Psicología');
        $email->setTo($data['email_usuario']);
        $email->setSubject('Notificación de Actualización de Información');
        $email->setMessage($message);

        try {
            $email->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
            return false;
        }
    }
}
