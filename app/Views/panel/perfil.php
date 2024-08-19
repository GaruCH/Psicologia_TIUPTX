<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>

<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <center>
                    <?php
                    // Definir la imagen por defecto basada en el sexo
                    $imagen_default = ($sexo === SEXO_FEMENINO) ? 'no-image-f.png' : 'no-image-m.png';

                    // Verificar si la imagen del usuario está disponible
                    $imagen_usuario = !empty($imagen) ? base_url(IMG_DIR_USUARIOS . '/' . $imagen) : base_url(IMG_DIR_USUARIOS . '/' . $imagen_default);
                    ?>
                    <img src="<?= $imagen_usuario ?>" alt="imagen_usuario" class="avatar-img rounded-circle" width="150px" id="img_editar" style="margin-bottom: 15px;" data-default-src="<?= base_url(IMG_DIR_USUARIOS . '/' . $imagen_default); ?>">
                </center>

                <?php
                $parametros = array('id' => 'formulario-usuario-nuevo');
                echo form_open_multipart('registrar_usuario', $parametros);
                ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Nombre(s):</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre ?>" readonly>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre(s)</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Apellido paterno:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" value="<?= $ap_paterno ?>" readonly>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido paterno</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Apellido materno:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="ap_materno" name="ap_materno" value="<?= $ap_materno ?>" readonly>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido materno</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Sexo:</label><br>
                        <div class="form-check form-check-inline mb-3">
                            <input type="radio" id="masculino" name="sexo" class="form-check-input radio-item" value="masculino" <?= $sexo == SEXO_MASCULINO ? 'checked' : '' ?> readonly>
                            <label class="form-check-label" for="masculino"><i class="fas fa-mars text-dark fill-white me-2"></i>Masculino</label>
                        </div>
                        <div class="form-check form-check-inline mb-3">
                            <input type="radio" id="femenino" name="sexo" class="form-check-input radio-item" value="femenino" <?= $sexo == SEXO_FEMENINO ? 'checked' : '' ?> readonly>
                            <label class="form-check-label" for="femenino"><i class="fas fa-venus text-dark fill-white me-2"></i>Femenino</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">E-mail:</label>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" readonly>
                            <label><i data-feather="at-sign" class="feather-sm text-dark fill-white me-2"></i>E-mail</label>
                        </div>
                    </div>



                    <?php if ($rol == ROL_PSICOLOGO['clave']): ?>
                        <!-- Campos específicos para psicólogos -->
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Numero de trabajador:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="numero_trabajador" name="numero_trabajador" value="<?= $numero_trabajador_psicologo ?>" readonly>
                                <label><i data-feather="hash" class="feather-sm text-dark fill-white me-2"></i>Numero de trabajdor(s)</label>
                            </div>
                        </div>
                </div>
                <div class="row justify-content-center">
                    <!-- Otros campos para psicólogos -->

                <?php elseif ($rol == ROL_PACIENTE['clave']): ?>
                    <!-- Campos específicos para pacientes -->
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Numero de expediente:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="expediente" name="expediente" value="<?= $expediente ?>" readonly>
                            <label><i data-feather="file-text" class="feather-sm text-dark fill-white me-2"></i>Expediente</label>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Referencia:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="referencia" name="referencia" value="<?= $referencia ?>" readonly>
                            <label><i data-feather="link" class="feather-sm text-dark fill-white me-2"></i>Referencia</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Atención:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="atencion" name="atencion" value="<?= $atencion ?>" readonly>
                            <label><i data-feather="info" class="feather-sm text-dark fill-white me-2"></i>Atención</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label">Papel:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="Papel" name="Papel" value="<?= $papel ?>" readonly>
                            <label><i data-feather="briefcase" class="feather-sm text-dark fill-white me-2"></i>Papel</label>
                        </div>
                    </div>
                </div>
                <!-- Campos según el tipo de paciente -->
                <?php if ($tipo_paciente == SUBCATEGORIA_ALUMNO['clave']): ?>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Matrícula:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="matricula" name="matricula" value="<?= $matricula ?>" readonly>
                                <label><i data-feather="hash" class="feather-sm text-dark fill-white me-2"></i>Matrícula</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Programa educativo:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="carrera" name="carrera" value="<?= $carrera ?>" readonly>
                                <label><i data-feather="book" class="feather-sm text-dark fill-white me-2"></i>Programa educativo</label>
                            </div>
                        </div>


                    <?php elseif ($tipo_paciente == SUBCATEGORIA_EMPLEADO['clave']): ?>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label">Número de trabajador:</label>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="numero_empleado" name="numero_empleado" value="<?= $numero_empleado ?>" readonly>
                                    <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Número de trabajador</label>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-control-label">Área:</label>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="area" name="area" value="<?= $area ?>" readonly>
                                    <label><i data-feather="book" class="feather-sm text-dark fill-white me-2"></i>Área</label>
                                </div>
                            </div>

                        <?php elseif ($tipo_paciente ==  SUBCATEGORIA_INVITADO['clave']): ?>
                            <div class="row justify-content-center">
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label">Identificador:</label>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="identificador" name="identificador" value="<?= $identificacion ?>" readonly>
                                        <label><i data-feather="tag" class="feather-sm text-dark fill-white me-2"></i>Identificador</label>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>


                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Imagen de perfil: </label>
                            <div class="input-group">
                                <?php
                                $parametros = array(
                                    'type' => 'file',
                                    'class' => 'form-control',
                                    'name' => 'imagen_perfil',
                                    'id' => 'imagen_perfil',
                                    'onchange' => "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);",
                                    'accept' => '.png, .jpeg, .jpg'
                                );
                                echo form_input($parametros);
                                ?>
                            </div>
                        </div>
                            </div>

                            <div class="text-center">
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
        <script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/preview-image.js") ?>"></script>
        <?= $this->endSection(); ?>