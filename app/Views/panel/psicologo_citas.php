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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nueva-cita" style="margin-bottom: 15px;">
            <i class="fas fa-lg fa-calendar-check"></i> Agendar cita
        </button>
        <div class="card">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0 text-center">Lista de citas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-citas" class="table table-striped table-bordered" style="width:100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th class="special-cell">#</th>
                                <th class="special-cell">Identificador</th>
                                <th class="special-cell">Paciente</th>
                                <th class="special-cell">Descripcion</th>
                                <th class="special-cell">Fecha</th>
                                <th class="special-cell">Hora Inicio</th>
                                <th class="special-cell">Estado</th>
                                <th class="special-cell">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal nueva-cita -->
<div class="modal fade" id="nueva-cita" tabindex="-1" aria-labelledby="nueva-cita-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center modal-colored-header bg-dark text-white" style="background: linear-gradient(45deg, #A7250D, #CC9933);">
                <h4 class="modal-title" id="nueva-cita-title">Nueva Cita</h4>
                <!---<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--->
            </div>
            <?php
            $parametros = array('id' => 'formulario-cita-nueva');
            echo form_open('registrar_cita_psicologo', $parametros);
            ?>
            <div class="modal-body">
                <div class="container-fluid">
                    <h5>Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                    <br>

                    <!-- Descripción de la cita -->

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label">Descripción de la cita: (<font color="red">*</font>)</label>
                        <div class="form-floating mb-3">
                            <?php
                            $parametros = array(
                                'class' => 'form-control',
                                'id' => 'descripcion',
                                'name' => 'descripcion',
                                'placeholder' => 'Descripción de la cita',
                                'value' => ''
                            );
                            echo form_textarea($parametros);
                            ?>
                            <div class="invalid-feedback"></div>
                            <label for="descripcion"><i data-feather="file-text" class="feather-sm text-dark fill-white me-2"></i>Descripción de la cita</label>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Paciente -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Paciente: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                $parametros = array(
                                    'class' => 'form-control',
                                    'id' => 'pacientes',
                                    'name' => 'pacientes',
                                    'placeholder' => 'Selecciona un paciente',
                                );
                                echo form_dropdown('pacientes', $pacientes, '', $parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label for="pacientes"><i data-feather="user" class="feather-sm text-dark fill-white me-2"><!-- Campo oculto para almacenar el ID del psicólogo -->

                                    </i>Pacientes</label>
                            </div>
                        </div>


                        <?php
                        // Campo oculto para el ID del psicólogo
                        $parametros_id_psicologo = array(
                            'type'  => 'hidden',
                            'id'    => 'id_psicologo',
                            'name'  => 'id_psicologo',
                            'value' => isset($id_psicologo) ? $id_psicologo : ''  // Asegúrate de que $id_psicologo esté definido
                        );
                        echo form_input($parametros_id_psicologo);
                        ?>

                        <!-- Fecha de la cita -->
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label">Fecha de la cita: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                $parametros = array(
                                    'type' => 'date',
                                    'class' => 'form-control',
                                    'id' => 'fecha_cita',
                                    'name' => 'fecha_cita',
                                    'placeholder' => 'Fecha de la cita',
                                    'required' => ''
                                );
                                echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label for="fecha_cita"><i data-feather="calendar" class="feather-sm text-dark fill-white me-2"></i>Fecha de la cita</label>
                            </div>
                        </div>

                    </div>

                    <div class="row justify-content-center">
                        <!-- Hora de la cita -->
                        <div class="col-md-6 mb-3" id="hora_cita_container" style="display:none;">
                            <label class="form-control-label">Hora de la cita: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                $parametros = array(
                                    'class' => 'form-control',
                                    'id' => 'hora_cita',
                                    'name' => 'hora_cita',
                                    'placeholder' => 'Selecciona una hora',
                                );
                                echo form_dropdown('hora_cita', [], '', $parametros); // Dejamos el dropdown vacío por defecto
                                ?>
                                <div class="invalid-feedback"></div>
                                <label for="hora_cita"><i data-feather="clock" class="feather-sm text-dark fill-white me-2"></i>Hora de la cita</label>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel-form-create-cita"><i class="fa fa-times"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" type="submit" id="btn-guardar-cita"><i class="fa fa-lg fa-save"></i> Agendar cita</button>
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
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/psicologo_citas.js") ?>"></script>
<?= $this->endSection(); ?>