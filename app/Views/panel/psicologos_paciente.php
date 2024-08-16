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
        <div class="card">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0 text-center">Lista de pacientes asignados</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-psicologo-pacientes" class="table table-striped table-bordered" style="width:100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th class="special-cell">#</th>
                                <th class="special-cell">Identificador</th>
                                <th class="special-cell">Nombre Completo</th>
                                <th class="special-cell">Sexo</th>
                                <th class="special-cell">Edad</th>
                                <th class="special-cell">Email</th>
                                <th class="special-cell">Papel</th>
                                <th class="special-cell">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ver-paciente -->
<div class="modal fade" id="ver-paciente" tabindex="-1" aria-labelledby="ver-paciente-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="ver-paciente-title">Ver Paciente</h4>
            </div>
            <?php
            $parametros = array('id' => 'formulario-paciente-ver');
            echo form_open('ver_paciente', $parametros);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <center>
                        <img src="<?php echo base_url(IMG_DIR_USUARIOS . "/no-image-m.png"); ?>" alt="imagen_usuario" class="avatar-img rounded-circle" width="150px" id="img_editar" style="margin-bottom: 15px;" data-default-src="<?php echo base_url(IMG_DIR_USUARIOS . '/no-image-m.png'); ?>">
                    </center>
                    <br>
                    <div class="row">
                        <!-- Numero de trabajador y Matrícula -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Numero de trabajador:</label>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="numero_trabajador" name="numero_trabajador" placeholder="Numero de trabajador" readonly>
                                <label><i data-feather="hash" class="feather-sm text-dark fill-white me-2"></i>Numero de trabajador</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Matrícula:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" readonly>
                                <label><i data-feather="hash" class="feather-sm text-dark fill-white me-2"></i>Matrícula</label>
                            </div>
                        </div>

                        <!-- Identificador y Nombre -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Identificador:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="identificador" name="identificador" placeholder="Identificador" readonly>
                                <label><i data-feather="tag" class="feather-sm text-dark fill-white me-2"></i>Identificador</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">E-mail:</label>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@dominio.com" readonly>
                                <label><i data-feather="at-sign" class="feather-sm text-dark fill-white me-2"></i>E-mail</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Nombre(s):</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)" readonly>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre(s)</label>
                            </div>
                        </div>

                        <!-- Apellido paterno y Apellido materno -->
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Apellido paterno:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" placeholder="Apellido Paterno" readonly>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido paterno</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Apellido materno:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="ap_materno" name="ap_materno" placeholder="Apellido Materno" readonly>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Apellido materno</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Sexo y E-mail -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Sexo:</label><br>
                            <div class="form-check form-check-inline mb-3">
                                <input type="radio" id="masculino" name="sexo" class="form-check-input radio-item" value="2" disabled>
                                <label class="form-check-label" for="masculino><i class=" fas fa-mars text-dark fill-white me-2"></i>Masculino</label>
                            </div>

                            <div class="form-check form-check-inline mb-3">
                                <input type="radio" id="femenino" name="sexo" class="form-check-input radio-item" value="1" disabled>
                                <label class="form-check-label" for="femenino"><i class="fas fa-venus text-dark fill-white me-2"></i>Femenino</label>
                            </div>
                        </div>


                        <!-- Fecha de Nacimiento -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Fecha de Nacimiento:</label>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" readonly>
                                <label><i data-feather="calendar" class="feather-sm text-dark fill-white me-2"></i>Fecha de Nacimiento</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Número de expediente y Referencia -->
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Número de expediente:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="num_expediente" name="num_expediente" placeholder="Número de expediente" readonly>
                                <label><i data-feather="file-text" class="feather-sm text-dark fill-white me-2"></i>Número de expediente</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Referencia:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Referencia" readonly>
                                <label><i data-feather="link" class="feather-sm text-dark fill-white me-2"></i>Referencia</label>
                            </div>
                        </div>

                        <!-- Atención -->
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Atención:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="atencion" name="atencion" placeholder="Atención" readonly>
                                <label><i data-feather="clipboard" class="feather-sm text-dark fill-white me-2"></i>Atención</label>
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <!-- Papel y Programa educativo -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Papel:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="papel" name="papel" placeholder="Papel" readonly>
                                <label><i data-feather="briefcase" class="feather-sm text-dark fill-white me-2"></i>Papel</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Programa educativo:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="programa_edu" name="programa_edu" placeholder="Programa educativo" readonly>
                                <label><i data-feather="book" class="feather-sm text-dark fill-white me-2"></i>Programa educativo</label>
                            </div>
                        </div>
                        <!-- Área -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Área:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="area" name="area" placeholder="Área" readonly>
                                <label><i data-feather="grid" class="feather-sm text-dark fill-white me-2"></i>Área</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Hecho</button>
            </div>
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
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/preview-image.js") ?>"></script>

<!-- SweetAlert 2 -->
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/sweetalert2/dist/manager-sweetalert2.js") ?>"></script>

<!-- jquery-validation Js -->
<script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS . "/jquery-validation/dist/jquery.validate.min.js") ?>"></script>

<!-- Form-options JS -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/form-options.js") ?>"></script>

<!-- Message Notification -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/message-notification.js") ?>"></script>

<!-- Loader Generator -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/loader-generator.js") ?>"></script>

<!-- JS específico -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/psicologos_paciente.js") ?>"></script>
<?= $this->endSection(); ?>