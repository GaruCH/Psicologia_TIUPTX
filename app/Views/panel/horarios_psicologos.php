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


    <div class="row mb-3">
        <div class="col">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevo-horario">
                <i class="fas fa-lg fa-clock"></i> Nueva hora
            </button>
        </div>
        <div class="col" style="text-align: right;">
            <button type="button" class="btn btn-primary ml-auto" id="save-changes">
                <i class="fas fa-lg fa-save"></i> Guardar cambios
            </button>
        </div>
    </div>
    <div class="card">
        <div class="border-bottom title-part-padding">
            <h4 class="card-title mb-0 text-center">Horas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-horario" class="table table-striped table-bordered" style="width:100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th class="special-cell">#</th>
                            <th class="special-cell">Día</th>
                            <th class="special-cell">Estado</th>
                            <th class="special-cell">Hora entrada</th>
                            <th class="special-cell">Hora salida</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

<!-- Modal nuevo-horario -->
<div class="modal fade" id="nuevo-horario" tabindex="-1" aria-labelledby="nuevo-horario-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="nuevo-horario-title">Nuevo Horario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
            $parametros = array('id' => 'formulario-horario');
            echo form_open('editar_horario', $parametros);
            ?>
            <div class="modal-body">
                <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Día: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = [

                                'class' => 'form-select',
                                'id' => 'dia',
                                'name' => 'dia'
                            ];
                            echo form_dropdown('dia', $dias, '', $parametros);
                            ?>

                            <div class="invalid-feedback"></div>
                            <label for="dia">
                                <i class="fas fa-lg fa-calendar-o text-dark fill-white me-2"></i>
                                Día de la semana
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Hora de entrada: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'time',
                                'class' => 'form-control',
                                'id' => 'hora_entrada',
                                'name' => 'hora_entrada',
                                'placeholder' => 'Hora de entrada',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i class="fas fa-clock text-dark fill-white me-2"></i>Hora de entrada</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Hora de salida: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'type' => 'time',
                                'class' => 'form-control',
                                'id' => 'hora_salida',
                                'name' => 'hora_salida',
                                'placeholder' => 'Hora de salida',
                                'value' => ''
                            );
                            echo form_input($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label><i class="fas fa-clock text-dark fill-white me-2"></i>Hora de salida</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-create-horario"><i class="fa fa-times"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" type="submit" id="btn-guardar-horario"><i class="fa fa-lg fa-save"></i> Guardar Horario</button>
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

<!-- Form-options JS -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/form-options.js") ?>"></script>

<!-- Message Notification -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/message-notification.js") ?>"></script>

<!-- Loader Generator -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/loader-generator.js") ?>"></script>

<!-- JS específico -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/horarios.js") ?>"></script>
<?= $this->endSection(); ?>