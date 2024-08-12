<?php

// =======================================================
// Funciones para crear un mensaje y mostrarlo en la vista
// =======================================================
function mensaje($texto = "", $tipo = 5, $titulo = "", $tiempo = 2000)
{
    $mensaje = array();
    $mensaje['titulo'] = $titulo;
    $mensaje['texto'] = $texto;
    $mensaje['tipo'] = $tipo;
    $mensaje['tiempo'] = $tiempo;
    session()->set('mensaje', $mensaje);
} //end of function asignar_mensaje

function mostrar_mensaje()
{
    $html = '';
    $session = session();
    $mensaje = $session->get("mensaje");
    $session->set("mensaje", null);

    if ($mensaje == null) {
        return "";
    } //end if no existe mensaje

    $type = '';
    switch ($mensaje['tipo']) {
        case SUCCESS_ALERT:
            $type = 'toastr.success';
            break;
        case DANGER_ALERT:
            $type = 'toastr.error';
            break;
        case INFO_ALERT:
            $type = 'toastr.info';
            break;
        case WARNING_ALERT:
            $type = 'toastr.warning';
            break;
        default:
            $type = 'toastr.info';
            break;
    } //end switch

    $options = '
    {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "showDuration": "100",
        "hideDuration": "100",
        "timeOut": "' . $mensaje['tiempo'] . '",
        "extendedTimeOut": "100",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "fadeOut"
    }
    ';

    $html .=
        '<script>' .
        $type . '(
            "' . $mensaje["texto"] . '",
            "' . $mensaje["titulo"] . '",
            ' . $options . '
           );
    </script>
    ';
    return $html;
} //end function mostrar_mensaje

// =======================================================
// Función para crear el breadcrumb dinámico del panel
// =======================================================
function breadcrumb_panel($navegacion = NULL, $titulo = NULL)
{
    $html = '
    <div class="col-md-6 align-self-center">
        <h3 class="page-title">' . $titulo . '</h3>
    </div>
    <div class="col-md-6 justify-content-end align-self-center d-none d-md-flex">
        <div class="d-flex">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb border border-primary px-3 rounded">
                        <li class="breadcrumb-item">
                            <a href="' . route_to('dashboard') . '" class="text-primary">
                                <i data-feather="home" class="feather-sm fill-white"></i>
                            </a>
                        </li>';
    foreach ($navegacion as $position => $tarea) {
        if ((sizeof($navegacion) - 1) == $position) {
            $html .= '
                                <li class="breadcrumb-item active text-primary font-weight-medium" aria-current="page">
                                    ' . $tarea['tarea'] . '
                                </li>
                                ';
        } //end if es la última posición
        else {
            $html .= '
                                <li class="breadcrumb-item">
                                    <a href="' . $tarea['href'] . '" class="text-primary" ' . $tarea['extra'] . '>
                                        ' . $tarea['tarea'] . '
                                    </a>
                                </li>
                                ';
        } //end else es la última posición
    } //end foreach navegacion
    $html .= '
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    ';
    return $html;
} //end breadcrumb_panel


// =======================================================
// Funciones para crear el  menú lateral del panel
// =======================================================
function configurar_menu_lateral_panel($rol_actual = NULL)
{
    $menu = array();
    $menu_item = array();
    $sub_menu_item = array();

    if ($rol_actual == ROL_SUPERADMIN['clave']) {
        //Sección Dashboard
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('dashboard');
        $menu_item['icon'] = 'fas fa-home';
        $menu_item['text'] = ' Dashboard';
        $menu_item['submenu'] = array();
        $menu['dashboard'] = $menu_item;

        //Sección Usuarios
        $menu_item = array();
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_usuarios');
        $menu_item['icon'] = 'fas fa-user';
        $menu_item['text'] = ' Usuarios';
        $menu_item['submenu'] = array();
        $menu['usuarios'] = $menu_item;

        //Sección Psicologos
        $menu_item = array();
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_psicologos');
        $menu_item['icon'] = 'fas fa-user-md';
        $menu_item['text'] = ' Psicólogos';
        $menu_item['submenu'] = array();
        $menu['psicologos'] = $menu_item;

        //Sección Ejemplo
        $menu_item = array();
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('ejemplo');
        $menu_item['icon'] = 'fas fa-user';
        $menu_item['text'] = ' Ejemplo';
        $menu_item['submenu'] = array();
        $menu['ejemplo'] = $menu_item;
    } elseif ($rol_actual == ROL_ADMIN['clave']) {
        //Sección Dashboard
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('dashboard');
        $menu_item['icon'] = 'fas fa-home';
        $menu_item['text'] = ' Dashboard';
        $menu_item['submenu'] = array();
        $menu['dashboard'] = $menu_item;

        //Sección Psicologos
        $menu_item = array();
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_psicologos');
        $menu_item['icon'] = 'fas fa-user-md';
        $menu_item['text'] = ' Psicólogos';
        $menu_item['submenu'] = array();
        $menu['psicologos'] = $menu_item;

        //Sección Asignaciones
        $menu_item = array();
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_asignaciones');
        $menu_item['icon'] = 'fas fa-list-alt';
        $menu_item['text'] = ' Asignaciones';
        $menu_item['submenu'] = array();
        $menu['administracion_asignaciones'] = $menu_item;
    } elseif ($rol_actual == ROL_PSICOLOGO['clave']) {

        //Sección Dashboard
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('dashboard_psicologo');
        $menu_item['icon'] = 'fas fa-home';
        $menu_item['text'] = ' Dashboard';
        $menu_item['submenu'] = array();
        $menu['dashboard_psicologo'] = $menu_item;

        //Sección Horario
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_horarios');
        $menu_item['icon'] = 'fas fa-calendar';
        $menu_item['text'] = ' Horario';
        $menu_item['submenu'] = array();
        $menu['administracion_horarios'] = $menu_item;

        
        //Sección Pacientes asignados
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('administracion_psicologo_pacientes');
        $menu_item['icon'] = 'fas fa-users';
        $menu_item['text'] = ' Pacientes';
        $menu_item['submenu'] = array();
        $menu['administracion_psicologo_pacientes'] = $menu_item;

         //Sección Historial Pacientes
         $menu_item['is_active'] = false;
         $menu_item['href'] = route_to('historial_psicologo_pacientes');
         $menu_item['icon'] = 'fas fa-history';
         $menu_item['text'] = ' Historial Pacientes';
         $menu_item['submenu'] = array();
         $menu['historial_psicologo_pacientes'] = $menu_item;

    } elseif ($rol_actual == ROL_PACIENTE['clave']) {

        //Sección Dashboard
        $menu_item['is_active'] = false;
        $menu_item['href'] = route_to('dashboard_paciente');
        $menu_item['icon'] = 'fas fa-home';
        $menu_item['text'] = ' Dashboard';
        $menu_item['submenu'] = array();
        $menu['dashboard_paciente'] = $menu_item;
    }


    /*menu con submenu de ejemplo*/
    // $menu_item = array();
    // $menu_item['is_active'] = FALSE;
    // $menu_item['href'] = '#';
    // $menu_item['icon'] = 'mdi mdi-notification-clear-all';
    // $menu_item['text'] = 'Menu principal';
    // $menu_item['submenu'] = array();
    //     //menú lateral Finalizados
    //     $sub_menu_item = array();
    //     $sub_menu_item['is_active'] = FALSE;
    //     $sub_menu_item['href'] = '';
    //     $sub_menu_item['icon'] = 'mdi mdi-octagram';
    //     $sub_menu_item['text'] = 'Tarea';
    //     $menu_item['submenu']['tarea'] = $sub_menu_item;
    // $menu['menu_principal'] = $menu_item;

    /*ejemplo menu con dos opciones*/
    // $menu_item = array();
    // $menu_item['is_active'] = FALSE;
    // $menu_item['href'] = '#';
    // $menu_item['icon'] = 'mdi mdi-notification-clear-all';
    // $menu_item['text'] = 'Primer Nivel';
    // $menu_item['submenu'] = array();
    //     //submenu
    //     $sub_menu_item = array();
    //     $sub_menu_item['is_active'] = FALSE;
    //     $sub_menu_item['href'] = '';
    //     $sub_menu_item['icon'] = 'mdi mdi-octagram';
    //     $sub_menu_item['text'] = 'Item 1.1';
    //     $menu_item['submenu']['tarea'] = $sub_menu_item;
    //     //submenú
    //     $sub_menu_item = array();
    //     $sub_menu_item['is_active'] = FALSE;
    //     $sub_menu_item['href'] = '#';
    //     $sub_menu_item['icon'] = 'mdi mdi-playlist-plus';
    //     $sub_menu_item['text'] = 'Segundo Nivel';
    //     $menu_item['submenu']['nombre_tarea'] = $sub_menu_item;
    //     $menu['menu'] = $menu_item;
    //         //Subsubmenu
    //         $sub_menu_item = array();
    //         $sub_menu_item['is_active'] = FALSE;
    //         $sub_menu_item['href'] = '';
    //         $sub_menu_item['icon'] = 'mdi mdi-octagram';
    //         $sub_menu_item['text'] = 'Item 1.2.1';
    //         $menu_item['submenu']['nombre_tarea']['submenu']['nombre_subtarea'] = $sub_menu_item;
    //         $menu['menu'] = $menu_item;
    // $menu['menu'] = $menu_item;

    return $menu;
} //end configurar_menu_lateral_panel

function activar_menu_item_panel($menu = NULL, $tarea_actual = NULL)
{
    $session = session();
    $rol_actual = $session->rol_actual['clave'];
    if ($rol_actual == ROL_SUPERADMIN['clave']) {
        switch ($tarea_actual) {
                //SECCIÓN DASHBOARD
            case TAREA_DASHBOARD:
                $menu['dashboard']['is_active'] = TRUE;
                break;
                //SECCIÓN USUARIOS
            case TAREA_USUARIOS:
            case TAREA_USUARIO_NUEVO:
            case TAREA_USUARIO_DETALLES:
                $menu['usuarios']['is_active'] = TRUE;
                break;
                //SECCIÓN ADMINISTRACIÓN PSICOLOGOS
            case TAREA_ADMIN_PSICOLOGOS:
                $menu['psicologos']['is_active'] = TRUE;
                break;
                //EJEMPLO
            case TAREA_EJEMPLO:
                $menu['ejemplo']['is_active'] = TRUE;
                break;
            default:
                break;
        } //end switch tarea actual
    } elseif ($rol_actual == ROL_ADMIN['clave']) {
        switch ($tarea_actual) {
                //SECCIÓN DASHBOARD
            case TAREA_DASHBOARD:
                $menu['dashboard']['is_active'] = TRUE;
                break;
                //SECCIÓN ADMINISTRACIÓN PSICOLOGOS
            case TAREA_ADMIN_PSICOLOGOS:
                $menu['psicologos']['is_active'] = TRUE;
                break;
                //SECCIÓN ASIGNACIONES PSICOLOGOS
            case TAREA_ADMIN_ASIGNACIONES:
                $menu['administracion_asignaciones']['is_active'] = TRUE;
                break;
            default:
                break;
        } //end switch tarea actual
    } elseif ($rol_actual == ROL_PSICOLOGO['clave']) {
        switch ($tarea_actual) {
                //SECCIÓN DASHBOARD
            case TAREA_PSICOLOGO_DASHBOARD:
                $menu['dashboard_psicologo']['is_active'] = TRUE;
                break;
                //SECCIÓN HORARIO
            case TAREA_PSICOLOGO_HORARIOS:
                $menu['administracion_horarios']['is_active'] = TRUE;
                break;
                //SECCIÓN PACIENTES ASIGNADOS
            case TAREA_PSICOLOGO_PACIENTES:
                $menu['administracion_psicologo_pacientes']['is_active'] = TRUE;
                break;
                   //SECCIÓN HISTORIAL PACIENTES
            case TAREA_PSICOLOGO_HISTORIAL_PACIENTES:
                $menu['historial_psicologo_pacientes']['is_active'] = TRUE;
                break;
            default:
                break;
        } //end switch tarea actual
    } elseif ($rol_actual == ROL_PACIENTE['clave']) {
        switch ($tarea_actual) {
                //SECCIÓN DASHBOARD
            case TAREA_PACIENTE_DASHBOARD:
                $menu['dashboard_paciente']['is_active'] = TRUE;
                break;
            default:
                break;
        } //end switch tarea actual
    } //end if ROL_OFICIAL


    /*
        Example to active the option menu

                NORMAL LEVEL
        FORMULE:
            - Section
        EXAMPLE:
            case TAREA_SECTION:
                $menu['section']['is_active'] = TRUE;
            break;

                ONE LEVEL
        FORMULE:
            - Section
                - Subsection
        EXAMPLE:
            case TAREA_SECTION:
                $menu['section']['is_active'] = TRUE;
                $menu['section']['submenu']['subsection']['is_active'] = TRUE;
            break;

                TWO LEVEL
        FORMULE:
            - Section
                - Subsection
                    - Subsection
        EXAMPLE:
            case TAREA_SECTION:
                $menu['section']['is_active'] = TRUE;
                $menu['section']['submenu']['subsection']['is_active'] = TRUE;
                $menu['section']['submenu']['subsection']['submenu']['subsubsection']['is_active'] = TRUE;
            break;
    */
    return $menu;
} //end activar_menu_item_panel

function crear_menu_panel()
{
    $html = '';
    $session = session();
    $menu = configurar_menu_lateral_panel($session->rol_actual['clave']);
    $menu = activar_menu_item_panel($menu, $session->tarea_actual);
    $html .= '
    <li class="nav-small-cap">
        <i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">' . $session->rol_actual['nombre'] . '</span>
    </li>';
    foreach ($menu as $menu_item) {
        if ($menu_item['href'] != '#') {
            $html .= '
            <li class="sidebar-item' . ($menu_item['is_active'] ? ' selected' : '') . '">
                <a class="sidebar-link waves-effect waves-dark sidebar-link' . ($menu_item['is_active'] ? ' active' : '') . '" href="' . $menu_item["href"] . '" aria-expanded="false">
                    <i class="' . $menu_item["icon"] . '"></i><span class="hide-menu"> ' . $menu_item["text"] . '</span>
                </a>
            </li>
            ';
        } //end if el menu_item es un sólo elemento
        else {
            $html .= '
            <li class="sidebar-item' . ($menu_item['is_active'] ? ' selected' : '') . '">
                <a class="sidebar-link has-arrow waves-effect waves-dark' . ($menu_item['is_active'] ? ' active' : '') . '" href="javascript:void(0)" aria-expanded="false">
                    <i class="' . $menu_item["icon"] . '"></i><span class="hide-menu"> ' . $menu_item["text"] . ' </span>
                </a>
            ';
            if (sizeof($menu_item['submenu']) > 0) {
                $html .= '
                <ul aria-expanded="false" class="collapse first-level' . ($menu_item['is_active'] ? ' in' : '') . '">
                ';
                foreach ($menu_item['submenu'] as $sub_menu_item) {
                    if ($sub_menu_item['href'] != '#') {
                        $html .= '
                            <li class="sidebar-item' . ($sub_menu_item['is_active'] ? ' active ' : '') . '">
                                <a href="' . $sub_menu_item['href'] . '" class="sidebar-link' . ($sub_menu_item['is_active'] ? ' active ' : '') . '">
                                    <i class="' . $sub_menu_item['icon'] . '"></i><span class="hide-menu"> ' . $sub_menu_item['text'] . ' </span>
                                </a>
                            </li>';
                    } //end if es un sólo subelemento sin otro nivel
                    else {
                        $html .= '
                            <li class="sidebar-item' . ($sub_menu_item['is_active'] ? ' active ' : '') . '">
                                <a class="has-arrow sidebar-link' . ($sub_menu_item['is_active'] ? ' active ' : '') . '" href="javascript:void(0)" aria-expanded="false">
                                    <i class="' . $sub_menu_item['icon'] . '"></i> <span class="hide-menu"> ' . $sub_menu_item['text'] . ' </span>
                                </a>
                            ';
                        if (isset($sub_menu_item['submenu'])) {
                            $html .= '
                                <ul aria-expanded="false" class="collapse second-level' . ($sub_menu_item['is_active'] ? ' in' : '') . '">
                                ';
                            foreach ($sub_menu_item['submenu'] as $sub_sub_menu_item) {
                                if ($sub_sub_menu_item['href'] != "#") {
                                    $html .= '
                                        <li class="sidebar-item">
                                            <a href="' . $sub_sub_menu_item['href'] . '" class="sidebar-link' . ($sub_sub_menu_item['is_active'] ? ' active ' : '') . '">
                                                <i class="' . $sub_sub_menu_item['icon'] . '"></i><span class="hide-menu"> ' . $sub_sub_menu_item['texto'] . '</span>
                                            </a>
                                        </li>
                                        ';
                                } //end if se tiene un href y no sólo un #
                            } //end foreach submenus del sub_menu_item
                            $html .= '
                                </ul>
                                ';
                        } //end if existe un submenu del submenu
                        $html .= '
                            </li>
                            ';
                    } //end else es un sólo subelemento sin otro nivel
                } //end foreach submenu item
                $html .= '</ul>';
            } //end if existen los subniveles
            $html .= '</li>';
        } //end else el menu_item es un sólo elemento
    } //end foreach $menu
    return $html;
}//end crear_menu_panel
