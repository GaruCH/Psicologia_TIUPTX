<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
<style>
    .about-section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }

    .container-fluid {
        position: relative;
    }

    .about-title {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .about-text {
        font-size: 1.3rem;
        margin-bottom: 20px;
    }

    .left-img {
        width: 25%;
        position: absolute;
        bottom: 0;
        padding-bottom: 2%;
    }

    .right-img {
    width: 11%;
    position: absolute;
    bottom: 0;
    right: 0;
    margin-right: 2.5%; 
    margin-bottom: 2%;
}
.list-unstyled{
    font-size: 1.3rem;
}

@media (max-width: 600px) {
    .right-img {
        margin-right: 7%; 
        margin-bottom: 2%; 
    }
}

</style>
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="about-title">Acerca del Gestor</h2>
            <p class="about-text">
                El gestor de información y pruebas psicológicas fue desarrollado por el laboratorio de cuerpos académicos de tecnologías de la información aplicadas y aplicaciones móviles (TIAMLab) de la Universidad Politécnica de Tlaxcala.
            </p>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled text-center">
                        <li class="mb-2">
                            <i class="fas fa-code"></i> Programador: Gabriel Cervantes Hernández
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-users"></i> M. C. Jorge Eduardo Xalteno Altamirano
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled text-center">
                        <li class="mb-2">
                            <i class="fas fa-users"></i> M. C. Augusto Meléndez Teodoro
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-users"></i> Ing. Emmanuel López Pérez
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-users"></i> M. C. Candy Atonal Nolasco
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<img src="<?= base_url(IMG_DIR_SISTEMA . '/UPTX.png') ?>" alt="Imagen izquierda" class="left-img">
<img src="<?= base_url(IMG_DIR_SISTEMA . '/TIAMLab.svg') ?>" alt="Imagen derecha" class="right-img">

<?= $this->endSection(); ?>

<?= $this->section("js") ?>
<!-- Puedes agregar scripts personalizados aquí si los necesitas -->
<?= $this->endSection(); ?>