<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="keywords" content="">
	    <meta name="description" content="">
	    <meta name="robots" content="noindex,nofollow">
	    <title>Cambio de correo | SSADUPTx</title>

	    <!-- Favicon icon -->
	    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(RECURSOS_PANEL_IMAGENES.'/favicon.png') ?>">
	    <!-- Custom CSS -->
	    <link href="<?= base_url(RECURSOS_PANEL_CSS.'/style.min.css') ?>" rel="stylesheet">
		<!-- Notification css (Toastr) -->
    	<link href="<?= base_url(RECURSOS_PANEL_PLUGINS.'/toastr/dist/build/toastr.min.css'); ?>" rel="stylesheet" >
	</head>


	<body style="background-color: #f4f7fa">

		<div class="main-wrapper">
	        <!-- ============================================================== -->
	        <!-- Preloader - style you can find in spinners.css -->
	        <!-- ============================================================== -->
	        <div class="preloader">
		        <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
		          <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#233242" stroke-width="2"></path>
		          <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#233242" stroke-width="2"></path>
		          <path id="teabag" fill="#233242" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
		          <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#233242"></path>
		          <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#233242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
		        </svg>
		    </div>

			<div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(<?= base_url(RECURSOS_PANEL_IMAGENES.'/big/auth-bg.jpg') ?>) no-repeat center center;">
	            <div class="auth-box p-4 bg-white rounded">
	                <div>
	                    <div class="logo text-center">
	                        <span class="db"><img alt="thumbnail" class="rounded-circle" width="120" src="<?= base_url(IMG_DIR_USUARIOS.'/'.$imagen_usuario) ?>"></span>
	                        <h1 class="font-weight-medium mb-3">¡Cambio De Correo!</h1>
	                    </div>
	                    <div class="row text-center">
	                        <div class="col-12">
								<p class="h5 font-weight-normal" style="color: #1f1f1f">
									¡Hola <?= $nombre ?>!<br>
									Se ha detectado que has cambiado de correo...<br>
									Deberás iniciar sesión nuevamente.<br>
									Lamentamos los inconvenientes causados.
								</p>
								<br>
								<a href="<?= route_to('login') ?>" class="btn btn-rounded btn-dark text-white" style="font-size: 24px">
									Continuar
								</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

		</div>

		<!-- ============================================================== -->
	    <!-- All Required JS -->
	    <!-- ============================================================== -->
		<script src="<?= base_url(RECURSOS_PANEL_PLUGINS.'/jquery/dist/jquery.min.js') ?>"></script>
	    <!-- Bootstrap tether Core JavaScript -->
	    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS.'/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
		<script>
	    	$(".preloader").fadeOut();
	    </script>
	</body>
</html>
