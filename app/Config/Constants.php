<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//************************************************************************
//********************* CONSTANTES SISTEMA *******************************
//************************************************************************
//=================================SISTEMA======================================
define("ACRONIMO_SISTEMA", 'SGTP');
define("NOMBRE_SISTEMA", 'Sistema Gestor de Test Psicologicos');
define("BACKGROUND_SISTEMA", 'fondo-uptx.jpg');
define("FAV_ICON_SISTEMA", 'logo-psicologia.ico');
define("LOGO_SISTEMA", 'logo-login-2.png');
define("BACKGROUND_SISTEMA_LOGIN", '');

/**
 * Ionos
 * SMTP: smtp.ionos.mx
 * PORT: 587
 * CRYPTO: tls
 * Gmail
 * SMTP: smtp.googlemail.com
 * PORT: 465
 * CRYPTO: ssl
 */
define('SMTP_PROTOCOL', 'smtp');
define('SMTP_HOST', 'smtp.ionos.mx');
define('SMTP_USER', 'developer_team@tiamlab.com');
define('SMTP_PASSWORD', 'So&lo.Ti-454M7a8.lbi40');
define('SMTP_PORT', 587);
define('SMTP_CRYPTO', 'tls');
define('SMTP_MAIL_TYPE', 'html');

define('CORREO_EMISOR_SISTEMA', 'developer_team@tiamlab.com');
define('COLOR_SISTEMA_INFO', '#009efb');
define('COLOR_SISTEMA_PRIMARY', '#7460ee');
define('COLOR_SISTEMA_SECONDARY', '#868e96');
define('COLOR_SISTEMA_SUCCESS', '#39c449');
define('COLOR_SISTEMA_WARNING', '#ffbc34');
define('COLOR_SISTEMA_DANGER', '#f62d51');

//ALERTAS
define("SUCCESS_ALERT", 1); //In JS The same
define("DANGER_ALERT", 2);  //In JS The same
define("INFO_ALERT", 3);    //In JS The same
define("WARNING_ALERT", 4); //In JS The same

//COLORES CON CLASE DE BOOTSTRAP PARA LOS CORREOS
define('COLOR_PRIMARY', '#7460ee');
define('COLOR_SECONDARY', '#868e96');
define('COLOR_SUCCESS', '#39c449');
define('COLOR_INFO', '#009efb');
define('COLOR_WARNING', '#ffbc34');
define('COLOR_DANGER', '#f62d51');

//RUTAS BASE PANEL
define("RECURSOS_PANEL_CSS", "recursos_panel_monster/css");         //In JS = R_P_C
define("RECURSOS_PANEL_JS", "recursos_panel_monster/js");           //In JS = R_P_J
define("RECURSOS_PANEL_IMAGENES", "recursos_panel_monster/images"); //In JS = R_P_I
define("RECURSOS_PANEL_PLUGINS", "recursos_panel_monster/plugins"); //In JS = R_P_P

//=================================ESTATUS======================================
//Habilitado/Deshabilitado
define("ESTATUS_HABILITADO", 2);     //In JS = E_H
define("ESTATUS_DESHABILITADO", -1); //In JS = E_D

//DIRECTORIOS
define("IMG_DIR_USUARIOS", "recursos_panel_monster/images/profile-images"); //In JS = I_D_O
define("IMG_DIR_SISTEMA", "images/sistema/"); //In JS = I_D_S
define("IMG_DIR_ICONOS", "images/iconos"); //In JS = I_D_I

define("_DIR_", ""); //In JS = 

//SEXOS
define("SEXO_FEMENINO", 1); //In JS = S_F
define("SEXO_MASCULINO", 2); //In JS = S_M

//ROLES
define("ROL_SUPERADMIN",  array('nombre' => 'Superadmin',           'clave' => '749'));
define("ROL_ADMIN",       array('nombre' => 'Admininistrador',      'clave' => '846'));
define("ROL_PSICOLOGO",   array('nombre' => 'Psicologo',            'clave' => '521'));
define("ROL_PACIENTE",    array('nombre' => 'Paciente',             'clave' => '496'));

define(
    "ROLES",
    array(
        ROL_SUPERADMIN["clave"] => ROL_SUPERADMIN["nombre"],
        ROL_ADMIN["clave"] =>      ROL_ADMIN["nombre"],
        ROL_PSICOLOGO["clave"] =>  ROL_PSICOLOGO["nombre"],
        ROL_PACIENTE["clave"] =>   ROL_PACIENTE["nombre"]
    )
);

//DIAS

define("DIA_LUNES",     array('nombre' => 'Lunes',      'clave' => '1'));
define("DIA_MARTES",    array('nombre' => 'Martes',     'clave' => '2'));
define("DIA_MIERCOLES", array('nombre' => 'Miércoles',  'clave' => '3'));
define("DIA_JUEVES",    array('nombre' => 'Jueves',     'clave' => '4'));
define("DIA_VIERNES",   array('nombre' => 'Viernes',    'clave' => '5'));
define("DIA_SABADO",    array('nombre' => 'Sábado',     'clave' => '6'));


define(
    "DIAS",
    array(
        DIA_LUNES["clave"] =>   DIA_LUNES["nombre"],
        DIA_MARTES["clave"] =>  DIA_MARTES["nombre"],
        DIA_MIERCOLES["clave"] => DIA_MIERCOLES["nombre"],
        DIA_JUEVES["clave"] =>   DIA_JUEVES["nombre"],
        DIA_VIERNES["clave"] =>  DIA_VIERNES["nombre"],
        DIA_SABADO["clave"] =>   DIA_SABADO["nombre"]
    )
);

//SUBCATEGORIA
define("SUBCATEGORIA_ALUMNO",    array('nombre' => 'Alumno',          'clave' => '439'));
define("SUBCATEGORIA_EMPLEADO",  array('nombre' => 'Empleado',        'clave' => '426'));
define("SUBCATEGORIA_INVITADO",  array('nombre' => 'Invitado',        'clave' => '411'));

define(
    "SUBCATEGORIAS",
    array(
        SUBCATEGORIA_ALUMNO["clave"] =>   SUBCATEGORIA_ALUMNO["nombre"],
        SUBCATEGORIA_EMPLEADO["clave"] => SUBCATEGORIA_EMPLEADO["nombre"],
        SUBCATEGORIA_INVITADO["clave"] => SUBCATEGORIA_INVITADO["nombre"]
    )
);

//TIPO ATENCION
define("TIPO_ATENCION_PRIMERA_VEZ", array('nombre' => 'Primera vez', 'clave' => '111'));
define("TIPO_ATENCION_SUBSUCUENTE", array('nombre' => 'Subsecuente', 'clave' => '122'));

define(
    "TIPOS_ATENCION",
    array(
        TIPO_ATENCION_PRIMERA_VEZ["clave"] => TIPO_ATENCION_PRIMERA_VEZ["nombre"],
        TIPO_ATENCION_SUBSUCUENTE["clave"] => TIPO_ATENCION_SUBSUCUENTE["nombre"]
    )
);

//TIPO REFERENCIA
define("TIPO_REFERENCIA_SERVICIO_MEDICO", array('nombre' => 'Servicio Médico',   'clave' => '211'));
define("TIPO_REFERENCIA_TUTOR", array('nombre' => 'Tutor',                       'clave' => '222'));
define("TIPO_REFERENCIA_DIRECTOR_CARRERA", array('nombre' => 'Director Carrera', 'clave' => '233'));
define("TIPO_REFERENCIA_OTRO", array('nombre' => 'Otro',                         'clave' => '244'));

define(
    "TIPOS_REFERENCIA_",
    array(
        TIPO_REFERENCIA_SERVICIO_MEDICO["clave"] => TIPO_REFERENCIA_SERVICIO_MEDICO["nombre"],
        TIPO_REFERENCIA_TUTOR["clave"] => TIPO_REFERENCIA_TUTOR["nombre"],
        TIPO_REFERENCIA_DIRECTOR_CARRERA["clave"] => TIPO_REFERENCIA_DIRECTOR_CARRERA["nombre"],
        TIPO_REFERENCIA_OTRO["clave"] => TIPO_REFERENCIA_OTRO["nombre"]
    )
);
//******************************************************************************
//***************************** PERMISOS DE LOS ROLES **************************
//******************************************************************************
// TAREA DASHBOARD
define("TAREA_DASHBOARD", "tarea_dashboard");

//TAREAS PROPIAS DEL USUARIO
define("TAREA_PERFIL", "tarea_perfil");
define("TAREA_PASSWORD", "tarea_password");

//TAREAS DE USUARIOS
define("TAREA_USUARIOS", "tarea_usuarios");
define("TAREA_USUARIO_NUEVO", "tarea_usuario_nuevo");
define("TAREA_USUARIO_DETALLES", "tarea_usuario_detalles");
define("TAREA_EJEMPLO", "tarea_ejemplo");


//TAREAS PARA EL PACIENTE
define("TAREA_PACIENTE_DASHBOARD", "tarea_paciente_dashboard");
//TAREAS PARA EL ADMIN
define("TAREA_ADMIN_DASHBOARD", "tarea_admin_dashboard");
define("TAREA_ADMIN_PSICOLOGOS", "tarea_admin_psicologos");
//TAREAS PARA EL PSICOLOGO
define("TAREA_PSICOLOGO_DASHBOARD", "tarea_psicologo_dashboard");
define("TAREA_PSICOLOGO_HORARIOS", "tarea_psicologo_horarios");

//******************************************************************************
//***************************** PERMISOS DE LOS ROLES **************************
//******************************************************************************
//PERMISOS SUPERADMIN
define(
    "PERMISOS_SUPERADMIN",
    array(
        TAREA_DASHBOARD,
        TAREA_PERFIL,
        TAREA_PASSWORD,
        TAREA_USUARIOS,
        TAREA_USUARIO_NUEVO,
        TAREA_USUARIO_DETALLES,
        TAREA_EJEMPLO,
        TAREA_ADMIN_PSICOLOGOS
    )
);

define(
    "PERMISOS_PACIENTE",
    array(
        TAREA_PACIENTE_DASHBOARD
    )
);
define(
    "PERMISOS_PSICOLOGO",
    array(
        TAREA_PSICOLOGO_DASHBOARD,
        TAREA_PSICOLOGO_HORARIOS
    )
);
define(
    "PERMISOS_ADMIN",
    array(
        TAREA_DASHBOARD,
        TAREA_ADMIN_PSICOLOGOS,
    )
);
