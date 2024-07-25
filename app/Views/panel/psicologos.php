<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
<!-- Datatables JS -->
<link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">

<!-- SweetAlert 2 -->
<link href="<?= base_url(RECURSOS_PANEL_PLUGINS . "/sweetalert2/dist/sweetalert2.min.css") ?>" rel="stylesheet">

<!-- Special Style -->
<link href="<?= base_url(RECURSOS_PANEL_CSS . "/style_owns.css") ?>" rel="stylesheet">
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>

<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevo-psicologo" style="margin-bottom: 15px;">
            <i class="fas fa-lg fa-user-md"></i> Agregar nuevo psicólogo
        </button>
        <div class="card">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0 text-center">Lista de psicólogos</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-psicologos" class="table table-striped table-bordered" style="width:100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th class="special-cell">#</th>
                                <th class="special-cell">Numero Trabajador</th>
                                <th class="special-cell">Nombre Completo</th>
                                <th class="special-cell">Sexo</th>
                                <th class="special-cell">Edad</th>
                                <th class="special-cell">Correo</th>
                                <th class="special-cell">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal nuevo-psicologo -->
<div class="modal fade" id="nuevo-psicologo" tabindex="-1" aria-labelledby="nuevo-psicologo-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="nuevo-psicologo-title">Nuevo Psicólogo</h4>
                <!---<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--->
            </div>
            <?php
            $parametros = array('id' => 'formulario-psicologo-nuevo');
            echo form_open('registrar_psicologo', $parametros);
            ?>
            <div class="modal-body">
                <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                <center>
                    <img src="<?php echo base_url(IMG_DIR_USUARIOS."/no-image-m.png");?>" alt="imagen_usuario" class="avatar-img rounded-circle" width="150px" id="img" style="margin-bottom: 15px;" data-default-src="<?php echo base_url(IMG_DIR_USUARIOS . '/no-image-m.png'); ?>">
                </center>
                <br>
                <div class="row">
    
                <div class="col-md-12 mb-3">
                        <label class="form-control-label">Numero de trabajador: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'type' => 'number',
                                'id' => 'numero_trabajador',
                                'name' => 'numero_trabajador',
                                'placeholder' => 'Numero de trabajador',
                                'min' => '0',
                                'maxlength' => '11',
                                'minlength' => '11'
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Numero de trabajador</label>
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Nombre(s): (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'nombre',
                                'name' => 'nombre',
                                'placeholder' => 'Nombre(s)',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre(s)</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Apellido paterno: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'ap_paterno',
                                'name' => 'ap_paterno',
                                'placeholder' => 'Apellido Paterno',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido paterno</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Apellido materno: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'ap_materno',
                                'name' => 'ap_materno',
                                'placeholder' => 'Apellido Materno',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido materno</label>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Sexo: (<font color="red">*</font>)</label><br>
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

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">E-mail: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'email',
                                'class' => 'form-control',
                                'id' => 'email',
                                'name' => 'email',
                                'placeholder' => 'ejemplo@dominio.com',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="at-sign" class="feather-sm text-dark fill-white me-2"></i>E-mail</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-control-label">Edad: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'number',
                                'class' => 'form-control',
                                'id' => 'edad',
                                'name' => 'edad',
                                'placeholder' => 'Edad',
                                'min' => '15', // Puedes ajustar el valor mínimo si es necesario
                                'max' => '99', // Puedes ajustar el valor máximo si es necesario
                                'maxlength' => '2'
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label for="edad"><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Edad</label>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Contraseña (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'password',
                                'class' => 'form-control',
                                'id' => 'password',
                                'autocomplete' =>'new-password',
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
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Confirmar contraseña (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'password',
                                'class' => 'form-control',
                                'id' => 'confirm_password',
                                'name' => 'confirm_password',
                                'autocomplete' =>'new-password',
                                'placeholder' => '**********',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="lock" class="feather-sm text-dark fill-white me-2"></i>Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Imagen de perfil: </label>
                        <div class="input-group">
                            <?php
                            $parametros = array(
                                'type' => 'file',
                                'class' => 'form-control',
                                'name' => 'imagen_perfil',
                                'id' => 'imagen_perfil',
                                'autocomplete' =>'new-password',
                                'onchange' => "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);",
                                'accept' => '.png, .jpeg, .jpg'
                            );
                            echo form_input($parametros);
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-create-psicologo"><i class="fa fa-times"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" type="submit" id="btn-guardar-psicologo"><i class="fa fa-lg fa-save"></i> Registrar psicólogo</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal cambiar-password -->
<div class="modal fade" id="cambiar-password-psicologo" tabindex="-1" aria-labelledby="cambiar-password-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="cambiar-password-title">Cambiar contraseña del psicólogo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
                $parametros = array('id' => 'formulario-cambiar-password-psicologo');
                echo form_open('actualizar_password_psicologo', $parametros);
            ?>
                <div class="modal-body">
                    <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                    <br>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Nueva contraseña (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'password_psicologo',
                                                        'name' => 'password_psicologo',
                                                        'autocomplete' =>'new-password',
                                                        'placeholder' => '**********',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <?php
                                    $parametros = array('type' => 'hidden',
                                                        'id' => 'id_psicologo_pass',
                                                        'name' => 'id_psicologo_pass',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <label><i data-feather="unlock" class="feather-sm text-dark fill-white me-2"></i>Nueva contraseña</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Confirmar contraseña (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('type' => 'password',
                                                        'class' => 'form-control',
                                                        'id' => 'confirm_password_psicologo',
                                                        'autocomplete' =>'new-password',
                                                        'name' => 'confirm_password_psicologo',
                                                        'placeholder' => '**********',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="lock" class="feather-sm text-dark fill-white me-2"> 
                                    </i>Confirmar contraseña</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-change-password-psicologo"><i class="fa fa-times"></i> Cancelar</button>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary" type="submit" id="btn-guardar"><i class="fa fa-lg fa-save"></i> Actualizar contraseña</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal editar-psicologo -->
<div class="modal fade" id="editar-psicologo" tabindex="-1" aria-labelledby="editar-psicologo-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="editar-psicologo-title">Editar Psicólogo</h4>
                <!---<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--->
            </div>
            <?php
            $parametros = array('id' => 'formulario-psicologo-editar');
            echo form_open('editar_psicologo', $parametros);
            ?>
            <div class="modal-body">
                <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                <center>
                    <img src="<?php echo base_url(IMG_DIR_USUARIOS."/no-image-m.png");?>" alt="imagen_usuario" class="avatar-img rounded-circle" width="150px" id="img_editar" style="margin-bottom: 15px;" data-default-src="<?php echo base_url(IMG_DIR_USUARIOS . '/no-image-m.png'); ?>">
                </center>
                <br>
                <div class="row">

                <div class="col-md-12 mb-3">
                        <label class="form-control-label">Numero de trabajador: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'type' => 'number',
                                'id' => 'numero_trabajador_editar',
                                'name' => 'numero_trabajador_editar',
                                'placeholder' => 'Numero de trabajador',
                                'min' => '0',
                                'maxlength' => '3',
                                'minlength' => '1'
                                
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Numero de trabajador</label>
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Nombre(s): (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'nombre_editar',
                                'name' => 'nombre_editar',
                                'placeholder' => 'Nombre(s)',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre(s)</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Apellido paterno: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'ap_paterno_editar',
                                'name' => 'ap_paterno_editar',
                                'placeholder' => 'Apellido Paterno',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido paterno</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Apellido materno: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'ap_materno_editar',
                                'name' => 'ap_materno_editar',
                                'placeholder' => 'Apellido Materno',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido materno</label>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Sexo: (<font color="red">*</font>)</label><br>
                        <div class="form-check form-check-inline mb-3">
                            <?php
                            $parametros = array(
                                'id' => 'masculino_editar',
                                'name' => 'sexo_editar',
                                'class' => 'form-check-input radio-item'
                            );
                            echo form_radio($parametros, SEXO_MASCULINO);
                            ?>
                            <label class="form-check-label" for="masculino"><i class="fas fa-mars text-dark fill-white me-2"></i>Masculino</label>
                        </div>
                        <div class="form-check form-check-inline mb-3">
                            <?php
                            $parametros = array(
                                'id' => 'femenino_editar',
                                'name' => 'sexo_editar',
                                'class' => 'form-check-input radio-item'
                            );
                            echo form_radio($parametros, SEXO_FEMENINO);
                            ?>
                            <label class="form-check-label" for="femenino"><i class="fas fa-venus text-dark fill-white me-2"></i>Femenino</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">E-mail: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'email',
                                'class' => 'form-control',
                                'id' => 'email_editar',
                                'name' => 'email_editar',
                                'placeholder' => 'ejemplo@dominio.com',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i data-feather="at-sign" class="feather-sm text-dark fill-white me-2"></i>E-mail</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-control-label">Edad: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'number',
                                'class' => 'form-control',
                                'id' => 'edad_editar',
                                'name' => 'edad_editar',
                                'placeholder' => 'Edad',
                                'min' => '15', // Puedes ajustar el valor mínimo si es necesario
                                'max' => '99', // Puedes ajustar el valor máximo si es necesario
                                'maxlength' => '2'
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label for="edad"><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Edad</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Imagen de perfil: </label>
                        <div class="input-group">
                            <?php
                            $parametros = array(
                                'type' => 'file',
                                'class' => 'form-control',
                                'name' => 'imagen_perfil_editar',
                                'id' => 'imagen_perfil_editar',
                                'onchange' => "validate_image(this, 'img_editar', 'btn-editar-psicologo', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);",
                                'accept' => '.png, .jpeg, .jpg'
                            );
                            echo form_input($parametros);
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-edit-psicologo"><i class="fa fa-times"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" id="btn-editar-psicologo" type="submit"><i class="fa fa-lg fa-save"><?php
                                    $parametros = array('type' => 'hidden',
                                                        'id' => 'id_psicologo_editar',
                                                        'name' => 'id_psicologo_editar',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?></i> Guardar cambios</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal loading -->
<div id="loader"></div>

<?= $this->endSection(); ?>

<?= $this->section("js") ?>
<!-- Datatables JS -->
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/datatables/media/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/datatables/media/js/custom-datatable.js") ?>"></script>
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/datatables/media/js/managerDataTables.js") ?>"></script>
<!-- Preview Image -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/preview-image.js") ?>"></script>

<!-- SweetAlert 2 -->
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/sweetalert2/dist/manager-sweetalert2.js") ?>"></script>

<!-- jquery-validation Js -->
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/jquery-validation/dist/jquery.validate.min.js") ?>"></script>

<!-- Form-options JS -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/form-options.js") ?>"></script>

 <!-- Message Notification -->
 <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/message-notification.js") ?>"></script>

 <!-- Loader Generator -->
  <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/loader-generator.js") ?>"></script>

<!-- JS específico -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/psicologos.js") ?>"></script>
<?= $this->endSection(); ?>