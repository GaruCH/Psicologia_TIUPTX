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
                <h4 class="card-title mb-0 text-center">Lista de asignaciones</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-asignaciones" class="table table-striped table-bordered" style="width:100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th class="special-cell">#</th>
                                <th class="special-cell">Numero de Trabajador</th>
                                <th class="special-cell">Nombre Psicólogo</th>
                                <th class="special-cell">Identificador Paciente</th>
                                <th class="special-cell">Nombre Paciente</th>
                                <th class="special-cell">Fecha de Asignacion</th>
                                <th class="special-cell">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editar-asignacion" tabindex="-1" aria-labelledby="editar-asignacion-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="editar-asignacion-title">Editar Asignacion</h4>
                <!---<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--->
            </div>
            <?php
            $parametros = array('id' => 'formulario-asignacion-editar');
            echo form_open('editar_asignacion', $parametros);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>

                    <br>
                    <div class="row">

                        <!-- Numero de trabajador -->
                        <div class="col-md-3 mb-3">
                            <label class="form-control-label">Numero de trabajador:</label>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="numero_trabajador" name="numero_trabajador" placeholder="Numero de trabajador" readonly>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Numero de trabajador</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Psicólogo: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                $parametros = [

                                    'class' => 'form-select',
                                    'id' => 'id_psicologo',
                                    'name' => 'id_psicologo',
                                ];
                                echo form_dropdown('id_psicologo', $psicologos, '', $parametros);
                                ?>

                                <div class="invalid-feedback"></div>
                                <label for="id_psicologo">
                                    <i class="fas fa-lg fa-calendar-o text-dark fill-white me-2"></i>
                                    Psicólogo
                                </label>
                            </div>
                        </div>


                        <!-- Identificador  -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Identificador:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="identificador" name="identificador" placeholder="Identificador" readonly>
                                <label><i data-feather="tag" class="feather-sm text-dark fill-white me-2"></i>Identificador</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                        <label class="form-control-label">Nombre del paciente:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre_paciente" name="nombre_paciente" placeholder="Nombre del Paciente" readonly>
                            <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre del Paciente</label>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-edit-asignacion"><i class="fa fa-times"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" id="btn-editar-asignacion" type="submit"><i class="fa fa-lg fa-save">
                        <?php
                        $parametros = array(
                            'type' => 'hidden',
                            'id' => 'id_asignacion_editar',
                            'name' => 'id_asignacion_editar',
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
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/asignaciones.js") ?>"></script>
<?= $this->endSection(); ?>