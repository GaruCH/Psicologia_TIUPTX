<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>
hola a todos
<!-- Modal loading -->
<div id="loader"></div>
<?= $this->endSection(); ?>

<?= $this->section("js") ?>
<!-- Form-options JS -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/form-options.js") ?>"></script>

<!-- Loader Generator -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/loader-generator.js") ?>"></script>

<!-- Message Notification -->
<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/owns/message-notification.js") ?>"></script>

<script src="<?php echo base_url(RECURSOS_PANEL_JS . "/specifics/dashboards.js") ?>"></script>
<?= $this->endSection(); ?>