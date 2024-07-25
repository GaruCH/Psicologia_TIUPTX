<!DOCTYPE html>
<html lang="es>

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
                                <span class="db"><img src="<?= base_url(IMG_DIR_SISTEMA . '/' . LOGO_SISTEMA) ?>" width="50%" alt="logo" /></span>
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
                    <div class="col-lg-4 col-xl-5 col-md-11">

                        <div class="row">
                            <div class="col-12">

                                <div class="card" id="loginform">
                                    <div class="card-body">
                                        <h2 class="text-center">Iniciar Sesión</h2>
                                        <?= form_open('validar_usuario', ['id' => 'form-login', 'class' => 'form-horizontal mt-4 pt-4 needs-validation']) ?>
                                        <div class="form-floating mb-3">
                                            <!-- <input type="email" class="form-control form-input-bg" id="tb-email" placeholder="name@example.com" required> -->
                                            <?php
                                            $parametros = array(
                                                'type' => 'email',
                                                'class' => 'form-control form-input-bg',
                                                'id' => 'tb-email',
                                                'name' => 'email',
                                                'placeholder' => 'name@example.com',
                                                'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                'required' => '',
                                                // 'maxlength' => '70'
                                            );
                                            echo form_input($parametros);
                                            ?>
                                            <div class="invalid-feedback"></div>
                                            <label for="tb-email" style="color: #FFFFFF;"><i data-feather="at-sign" class="feather-sm text-white fill-white me-2"></i>Correo electrónico</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <!-- <input type="password" class="form-control form-input-bg" id="text-password" placeholder="*****" required> -->
                                            <?php
                                            $parametros = array(
                                                'type' => 'password',
                                                'class' => 'form-control',
                                                'id' => 'text-password',
                                                'name' => 'password',
                                                'placeholder' => 'Contraseña',
                                                'required' => '',
                                                'style' => 'background-color: #CC9933; color: #FFFFFF;',
                                                'maxlength' => '18'
                                            );
                                            echo form_password($parametros);
                                            ?>
                                            <div class="invalid-feedback"></div>
                                            <label for="text-password" style="color: #FFFFFF;"><i data-feather="lock" class="feather-sm text-white fill-white me-2"></i>Contraseña</label>
                                            
                                        </div>

                                        <div class="d-flex align-items-center mb-3">
                                            <div class="ms-auto">
                                                <a href="<?= route_to('recuperar_contraseña') ?>" class="fw-bold" style="color: #808080">¿Olvidaste tu contraseña?</a>
                                            </div>
                                        </div>


                                        <div class="form-group text-center mt-4 mb-3">
                                            <div class="col-xs-12">
                                                <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit" style="background: #A7250D; border-color: #CC9933; color:#ffff">Iniciar sesión</button>
                                                <br>
                                                <h4 class="text-center">¿Eres un paciente?</h4>
                                                <a href="<?= route_to('registro_paciente') ?>" class="fw-bold" style="color: #808080">Registrate</a>
                                            </div>
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
    <script src="<?= base_url(RECURSOS_PANEL_JS . "/specifics/login.js") ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/feather.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/custom.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.js'); ?>"></script>
    <!-- Message Notification -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/message-notification.js") ?>"></script>
    <!-- Constants Js -->
    <script src="<?= base_url(RECURSOS_PANEL_JS . '/constants.js'); ?>"></script>

    <?= mostrar_mensaje(); ?>
</body>

</html>