<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, monster admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, ">
    <meta name="description" content="monster is powerful and clean admin dashboard template">
    <meta name="robots" content="noindex,nofollow">
    <title><?= ACRONIMO_SISTEMA ?> - Acceso</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(IMG_DIR_SISTEMA . '/' . FAV_ICON_SISTEMA) ?>">
    <link href="<?= base_url(RECURSOS_PANEL_CSS . '/style.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr_manager.css'); ?>" rel="stylesheet">
    <!-- Favicon icon -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png"> -->
    <!-- Custom CSS -->
    <!-- <link href="../../dist/css/style.min.css" rel="stylesheet"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <div class="preloader">
            <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#2962FF" stroke-width="2"></path>
                <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#2962FF" stroke-width="2"></path>
                <path id="teabag" fill="#2962FF" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
                <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#2962FF"></path>
                <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#2962FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
        <div class="row auth-wrapper gx-0">
            <div class="col-lg-3 col-xl-3 auth-box-2 on-sidebar" style="background:#A7250D;">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-7 col-lg-12 col-xl-9">
                            <div>
                                <span class="db"><img src="<?= base_url(IMG_DIR_SISTEMA . '/' . LOGO_SISTEMA) ?>" width="40%" alt="logo" /></span>
                                <!-- <span class="db"><img src="../assets/images/logo-light-text.png" alt="logo" /></span> -->
                            </div>
                            <h2 class="text-white mt-4 fw-light"><?= NOMBRE_SISTEMA ?></h2>
                            <!-- <p class="op-5 text-white fs-4 mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-xl-9 d-flex align-items-center justify-content-center" style="background:url(<?= base_url(IMG_DIR_SISTEMA . '/' . BACKGROUND_SISTEMA) ?>) no-repeat center center; background-size: cover;">
                <div class="row justify-content-center w-100 mt-4 mt-lg-0 ">
                    <div class="col-lg-8 col-xl-7 col-md-13">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" id="loginform">
                                    <div class="card-body">
                                        <h4 class="card-title">Registro Paciente</h4>
                                        <h5 class="card-subtitle mb-3 pb-3 border-bottom">Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                                        <?php
                                        $parametros = array('id' => 'formulario-paciente-nuevo');
                                        echo form_open_multipart('registrar_paciente', $parametros);
                                        ?>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Nombre(s): (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!--   <input type="text" class="form-control form-input-bg" id="tb-rfname" placeholder="john deo" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'text',
                                                        'class' => 'form-control',
                                                        'id' => 'nombre',
                                                        'name' => 'nombre',
                                                        'placeholder' => 'Nombre',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;'
                                                        // 'maxlength' => '70'
                                                    );
                                                    echo form_input($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="nombre" style="color: #FFFFFF;"><i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Nombre</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Apellido paterno: (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!--   <input type="text" class="form-control form-input-bg" id="tb-rfname" placeholder="john deo" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'text',
                                                        'class' => 'form-control',
                                                        'id' => 'ap_paterno',
                                                        'name' => 'ap_paterno',
                                                        'placeholder' => 'Apellido Paterno',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'required' => '',
                                                        // 'maxlength' => '70'
                                                    );
                                                    echo form_input($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="ap_paterno" style="color: #FFFFFF;"><i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Apellido paterno</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Apellido materno: (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!--   <input type="text" class="form-control form-input-bg" id="tb-rfname" placeholder="john deo" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'text',
                                                        'class' => 'form-control form-input-bg',
                                                        'id' => 'ap_materno',
                                                        'name' => 'ap_materno',
                                                        'placeholder' => 'Apellido Materno',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'required' => '',
                                                        // 'maxlength' => '70'
                                                    );
                                                    echo form_input($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="ap_materno" style="color: #FFFFFF;"><i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Apellido materno</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Sexo: (<font color="red">*</font>)</label><br>
                                                <div class="form-floating mb-3">
                                                    <div class="form-check form-check-inline mb-3">
                                                        <?php
                                                        $parametros = array(
                                                            'id' => 'masculino',
                                                            'name' => 'sexo',
                                                            'class' => 'form-check-input radio-item'
                                                        );
                                                        echo form_radio($parametros, SEXO_MASCULINO);
                                                        ?>
                                                        <label class="form-check-label" for="masculino"><i class="fas fa-mars text-dark fill-white me-2"></i>Masculino</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline mb-3">
                                                    <?php
                                                    $parametros = array(
                                                        'id' => 'femenino',
                                                        'name' => 'sexo',
                                                        'class' => 'form-check-input radio-item'
                                                    );
                                                    echo form_radio($parametros, SEXO_FEMENINO);
                                                    ?>
                                                    <label class="form-check-label" for="femenino"><i class="fas fa-venus text-dark fill-white me-2"></i>Femenino</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Contraseña (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!-- <input type="password" class="form-control form-input-bg" id="text-password" placeholder="*****" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'passwordr',
                                                        'name' => 'passwordr',
                                                        'placeholder' => 'Contraseña',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'required' => '',
                                                        'maxlength' => '18'
                                                    );
                                                    echo form_password($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="text-password" style="color: #FFFFFF;"><i data-feather="unlock" class="feather-sm text-white fill-white me-2"></i>********</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Confirmar contraseña (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!-- <input type="password" class="form-control form-input-bg" id="text-password" placeholder="*****" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'confirm_passwordr',
                                                        'name' => 'confirm_passwordr',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'placeholder' => 'Contraseña',
                                                        'required' => '',
                                                        'maxlength' => '18'
                                                    );
                                                    echo form_password($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="confirm_passwordr" style="color: #FFFFFF;"><i data-feather="lock" class="feather-sm text-white fill-white me-2"></i>********</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <label class="form-control-label">E-mail: (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <!-- <input type="email" class="form-control form-input-bg" id="tb-email" placeholder="name@example.com" required> -->
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'email',
                                                        'class' => 'form-control form-input-bg',
                                                        'id' => 'emailr',
                                                        'name' => 'emailr',
                                                        'placeholder' => 'name@example.com',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'required' => '',
                                                        // 'maxlength' => '70'
                                                    );
                                                    echo form_input($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="emailr" style="color: #FFFFFF;"><i data-feather="at-sign" class="feather-sm text-white fill-white me-2"></i>Correo electrónico</label>

                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                <label class="form-control-label">Edad: (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <?php
                                                    $parametros = array(
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                        'id' => 'edad',
                                                        'name' => 'edad',
                                                        'placeholder' => 'Edad',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                        'min' => '15', // Puedes ajustar el valor mínimo si es necesario
                                                        'max' => '99', // Puedes ajustar el valor máximo si es necesario
                                                        'maxlength' => '2'
                                                    );
                                                    echo form_input($parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="edad" style="color: #FFFFFF;"><i data-feather="user" class="feather-sm text-white fill-white me-2"></i>Edad</label>
                                                </div>
                                            </div>

                                            <div class="col-md-5 mb-2">
                                                <label class="form-control-label">Ocupación del usuario: (<font color="red">*</font>)</label>
                                                <div class="form-floating mb-3">
                                                    <?php
                                                    $parametros = [
                                                        'class' => 'form-select',
                                                        'id' => 'subcategoria',
                                                        'style' => 'background-color: #CC9933; color: #FFFFFF;'
                                                    ];
                                                    echo form_dropdown('subcategoria', ['' => 'Seleccione una ocupación...'] + $subcategorias, '', $parametros);
                                                    ?>
                                                    <div class="invalid-feedback"></div>
                                                    <label for="subcategoria" style="color: #FFFFFF;">
                                                        <i class="fas fa-lg fa-address-card text-white fill-white me-2"></i>
                                                        ocupación
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-stretch button-group justify-content-center">
                                            <button type="submit" class="btn btn-info px-4" style="background: #A7250D; color:#ffff; border-color: #CC9933;">Registrarse</button>
                                            <a href="<?= route_to('login') ?>" class="btn btn-light-secondary text-secondary font-weight-medium">Cancelar</a>
                                        </div>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- All Required js -->
    <!-- -------------------------------------------------------------- -->
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/jquery-sparkline/jquery.sparkline.min.js') ?>"></script>
    <!--Custom JavaScript -->
    <!-- jquery-validation Js -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/jquery-validation/dist/jquery.validate.min.js") ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/feather.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/custom.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.js'); ?>"></script>
    <!-- Message Notification -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/message-notification.js") ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . "/specifics/register.js") ?>"></script>
    <!-- Constants Js -->
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/constants.js'); ?>"></script>

    <?= mostrar_mensaje(); ?>
</body>

</html>