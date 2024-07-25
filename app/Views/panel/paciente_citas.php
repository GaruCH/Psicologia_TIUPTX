<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
    <!-- Datatables JS -->
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS.'/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">

    <!-- SweetAlert 2 -->
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.min.css") ?>" rel="stylesheet">

    <!-- Special Style -->
    <link href="<?= base_url(RECURSOS_PANEL_CSS."/style_owns.css") ?>" rel="stylesheet">
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>


<?= $this->endSection(); ?>

<?= $this->section("js") ?>
    <!-- Datatables JS -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/datatables/media/js/jquery.dataTables.min.js") ?>"></script>
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/datatables/media/js/custom-datatable.js") ?>"></script>
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/datatables/media/js/managerDataTables.js") ?>"></script>

    <!-- SweetAlert 2 -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/manager-sweetalert2.js") ?>"></script>

    <!-- jquery-validation Js -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/jquery-validation/dist/jquery.validate.min.js") ?>"></script>

    <!-- Form-options JS -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/form-options.js") ?>"></script>

    <!-- JS específico -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/specifics/usuarios.js") ?>"></script>
<?= $this->endSection(); ?>

