<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
    <!-- SweetAlert 2 -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.min.css") ?>">
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Editar usuario</h4>
                <h5 class="card-subtitle mb-3 pb-3 border-bottom">Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                <center>
                    <img src="<?= base_url(IMG_DIR_USUARIOS.'/'.($usuario->imagen_usuario == NULL ? ($usuario->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') : $usuario->imagen_usuario));?>"
                         alt="imagen_usuario" class="avatar-img rounded-circle" width="150px" id="img" style="margin-bottom: 15px;" data-image="<?= ($usuario->imagen_usuario == NULL ? 'false' : 'true') ?>">
                </center>
                <?php
                    $parametros = array('id' => 'formulario-usuario-editar');
                    echo form_open_multipart('editar_usuario', $parametros);
                ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Nombre(s): (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'nombre',
                                                        'name' => 'nombre',
                                                        'placeholder' => 'Nombre(s)',
                                                        'value' => $usuario->nombre_usuario
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre(s)</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Apellido paterno: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'ap_paterno',
                                                        'name' => 'ap_paterno',
                                                        'placeholder' => 'Apellido Paterno',
                                                        'value' => $usuario->ap_paterno_usuario
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido paterno</label>
                                <?php
                                    $parametros = array('type' => 'hidden',
                                                        'id' => 'id_usuario',
                                                        'name' => 'id_usuario',
                                                        'value' => $usuario->id_usuario
                                                        );
                                    echo form_input($parametros);
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Apellido materno: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'ap_materno',
                                                        'name' => 'ap_materno',
                                                        'placeholder' => 'Apellido Materno',
                                                        'value' => $usuario->ap_materno_usuario
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido materno</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Rol del usuario: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-select',
                                                        'id' => 'rol'
                                                        );
                                    echo form_dropdown('rol', $roles, $usuario->id_rol, $parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i class="fas fa-lg fa-address-card text-dark fill-white me-2"></i>Rol del usuario</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Sexo: (<font color="red">*</font>)</label><br>
                            <div class="form-check form-check-inline mb-3">
                                <?php
                                    $parametros = array('id' => 'masculino',
                                                        'name' => 'sexo',
                                                        'class' => 'form-check-input radio-item'
                                                        );
                                    echo form_radio($parametros, SEXO_MASCULINO, ($usuario->sexo_usuario == SEXO_MASCULINO ? TRUE : FALSE));
                                ?>
                                <label class="form-check-label" for="masculino"><i class="fas fa-mars text-dark fill-white me-2"></i>Masculino</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <?php
                                    $parametros = array('id' => 'femenino',
                                                        'name' => 'sexo',
                                                        'class' => 'form-check-input radio-item'
                                                        );
                                    echo form_radio($parametros, SEXO_FEMENINO, ($usuario->sexo_usuario == SEXO_FEMENINO ? TRUE : FALSE));
                                ?>
                                <label class="form-check-label" for="femenino"><i class="fas fa-venus text-dark fill-white me-2"></i>Femenino</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">E-mail: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('type' => 'email',
                                                        'class' => 'form-control',
                                                        'id' => 'email',
                                                        'name' => 'email',
                                                        'placeholder' => 'ejemplo@dominio.com',
                                                        'value' => $usuario->email_usuario
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="at-sign" class="feather-sm text-dark fill-white me-2"></i>E-mail</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-control-label">Contraseña </label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'password',
                                                        'name' => 'password',
                                                        'placeholder' => '**********',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="unlock" class="feather-sm text-dark fill-white me-2"></i>Contraseña</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-control-label">Confirmar contraseña </label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'confirm_password',
                                                        'name' => 'confirm_password',
                                                        'placeholder' => '**********',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="lock" class="feather-sm text-dark fill-white me-2"></i>Confirmar contraseña</label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-3"></div>
                        <div class="col-md-5 mb-3">
                            <label class="form-control-label">Imagen de perfil: </label>
                            <div class="input-group">
                                <?php
                                    $parametros = array('type' => 'file',
                                                        'class' => 'form-control',
                                                        'name' => 'imagen_perfil',
                                                        'id' => 'imagen_perfil',
                                                        'onchange' => "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/".($usuario->imagen_usuario == NULL ? ($usuario->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') : $usuario->imagen_usuario)."', 512, 512);",
                                                        'accept' => '.png, .jpeg, .jpg'
                                                       );
                                    echo form_input($parametros);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a type="button" href="<?= route_to('administracion_usuarios') ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
                        &nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" type="submit" id="btn-guardar"><i class="fa fa-lg fa-save"></i> Guardar cambios</button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("js") ?>
    <!-- Preview Image -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/preview-image.js") ?>"></script>

    <!-- SweetAlert 2 -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/manager-sweetalert2.js") ?>"></script>

    <!-- jquery-validation Js -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/jquery-validation/dist/jquery.validate.min.js") ?>"></script>

    <!-- Message Notification -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/message-notification.js") ?>"></script>

    <!-- JS específico -->
    <script>
        let urlImg = "../../recursos_panel_monster/images/profile-images/<?= ($usuario->imagen_usuario == NULL ? ($usuario->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') : $usuario->imagen_usuario) ?>";
    </script>
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/specifics/usuario_detalles.js") ?>"></script>
<?= $this->endSection(); ?>
