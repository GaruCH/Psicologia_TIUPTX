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
	<title><?= $nombre_pagina ?> | <?= ACRONIMO_SISTEMA ?></title>

	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(IMG_DIR_SISTEMA . '/' . FAV_ICON_SISTEMA) ?>">

	<!-- *********************************************** -->
	<!-- ********* CSS ESPECÍFICO SELECT2 ********* -->
	<?= $this->renderSection("css_select2") ?>
	<!-- *********************************************** -->
	<!-- *********************************************** -->

	<!-- Custom CSS -->
	<link href="<?= base_url(RECURSOS_PANEL_CSS . '/style.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url(RECURSOS_PANEL_CSS . '/font-awesom.all.min.css') ?>" rel="stylesheet">




	<!-- Notification css (Toastr) -->
	<link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr_manager.css'); ?>" rel="stylesheet">

	<!-- *********************************************** -->
	<!-- ********* CSS ESPECÍFICOS DE LA VISTA ********* -->
	<?= $this->renderSection("css") ?>
	<!-- *********************************************** -->
	<!-- *********************************************** -->
</head>

<body>

	<!-- ============================================================== -->
	<!-- Preloader - style you can find in spinners.css -->
	<!-- ============================================================== -->
	<div class="preloader">
		<svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#009efb" stroke-width="2"></path>
			<path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#009efb" stroke-width="2"></path>
			<path id="teabag" fill="#009efb" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
			<path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#009efb"></path>
			<path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#009efb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
		</svg>
	</div>

	<!-- ============================================================== -->
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<header class="topbar">
			<nav class="navbar top-navbar navbar-expand-md navbar-dark ">
				<div class="navbar-header" style="background: #A7250D;">
					<!-- This is for the sidebar toggle which is visible on mobile only -->
					<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
					<!-- ============================================================== -->
					<!-- Logo -->
					<!-- ============================================================== -->
					<a class="navbar-brand" style="background: #A7250D;" href="<?= route_to('dashboard') ?>">
						<!-- Logo icon -->
						<b class="logo-icon">
							<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
							<!-- Dark Logo icon -->
							<!-- <img src="<?= base_url(RECURSOS_PANEL_IMAGENES . '/logo-icon.png') ?>" alt="Principal" class="dark-logo" /> -->
							<img src="<?= base_url(IMG_DIR_SISTEMA . '/' . LOGO_SISTEMA) ?>" alt="Principal" class="dark-logo" width="50%" />
							<!-- Light Logo icon -->
							<img src="<?= base_url(IMG_DIR_SISTEMA . '/' . LOGO_SISTEMA) ?>" alt="Principal" class="light-logo" width="100%" />
						</b>
						<!--End Logo icon -->

						<!-- Logo text -->
						<span class="logo-text">
							<!-- dark Logo text -->
							<!-- <img src="<?= base_url(RECURSOS_PANEL_IMAGENES . '/logo-text.png') ?>" alt="Principal" class="dark-logo" /> -->
							<!-- Light Logo text -->
							<!-- <img src="<?= base_url(RECURSOS_PANEL_IMAGENES . '/logo-light-text.png') ?>" class="light-logo" alt="Principal" /> -->
						</span>
					</a>
					<!-- ============================================================== -->
					<!-- End Logo -->
					<!-- ============================================================== -->
					<!-- ============================================================== -->
					<!-- Toggle which is visible on mobile only -->
					<!-- ============================================================== -->
					<a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="ti-more"></i>
					</a>
				</div>
				<!-- ============================================================== -->
				<!-- End Logo -->
				<!-- ============================================================== -->
				<div class="navbar-collapse collapse" style="background: linear-gradient(45deg, #A7250D, #CC9933);" id="navbarSupportedContent">
					<!-- ============================================================== -->
					<!-- toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav me-auto">
						<li class="nav-item d-none d-md-block">
							<a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
								<i class="mdi mdi-menu" style="font-size: 26px"></i>
							</a>
						</li>
					</ul>
					<!-- ============================================================== -->
					<!-- Right side toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav">
						<!-- ============================================================== -->
						<!-- Notifications -->
						<!-- ============================================================== -->
						<!-- Notifications Dropdown -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="mdi mdi-bell" style="font-size: 28px;"></i>
								<div class="notify">
									<?php if (!empty($notificaciones)) : ?>
										<span class="heartbit"></span> <span class="point"></span>
									<?php endif; ?>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-start mailbox dropdown-menu-animate-up">
								<ul class="list-style-none">
									<li>
										<div class="border-bottom rounded-top py-3 px-4">
											<div class="mb-0 font-weight-medium fs-4">Notificaciones</div>
										</div>
									</li>
									<li>
										<div class="message-center notifications position-relative" style="height:230px; overflow-y: auto;">
											<?php if (!empty($notificaciones)) : ?>
												<?php foreach ($notificaciones as $notificacion) : ?>
													<?php
													// Define styles based on type of notification
													$btnClass = 'btn-info'; // Default
													$icon = 'info'; // Default icon

													switch ($notificacion['tipo_notificacion']) {
														case 'success':
															$btnClass = 'btn-success';
															$icon = 'check';
															break;
														case 'warning':
															$btnClass = 'btn-warning';
															$icon = 'alert-triangle';
															break;
														case 'danger':
															$btnClass = 'btn-danger';
															$icon = 'alert-octagon';
															break;
													}
													?>
													<a href="#" class="message-item d-flex align-items-center border-bottom px-3 py-2" data-bs-toggle="modal" data-bs-target="#notificacionModal" data-id="<?= $notificacion['id_notificacion'] ?>" data-rol="<?= $notificacion['rol'] ?>" data-fecha="<?= $notificacion['fecha'] ?>" data-titulo="<?= $notificacion['titulo_notificacion'] ?>" data-mensaje="<?= $notificacion['mensaje'] ?>" data-estado="<?= $notificacion['leida'] ?>" data-tipo="<?= $notificacion['tipo_notificacion'] ?>">
														<span class="btn <?= $btnClass ?> text-white btn-circle">
															<i data-feather="<?= $icon ?>" class="feather-sm fill-white"></i>
														</span>
														<div class="w-75 d-inline-block v-middle ps-3">
															<h5 class="message-title mb-0 mt-1 fs-3 fw-bold"><?= $notificacion['titulo_notificacion'] ?></h5>
															<span class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1">
																<?= substr($notificacion['mensaje'], 0, 50) ?>...
															</span>
															<span class="fs-2 text-nowrap d-block subtext text-muted"><?= $notificacion['fecha'] ?? 'No hay fecha' ?></span>
														</div>
													</a>
												<?php endforeach; ?>
											<?php else : ?>
												<div class="px-3 py-2 text-center text-muted">No hay notificaciones</div>
											<?php endif; ?>
										</div>
									</li>
									<li>
										<a class="nav-link border-top text-center text-dark pt-3" href="#" data-bs-toggle="modal" data-bs-target="#verTodasModal">
											<strong>Ver todas las notificaciones</strong> <i class="fa fa-angle-right"></i>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- ============================================================== -->
						<!-- End Notifications -->
						<!-- ============================================================== -->

						<!-- ============================================================== -->
						<!-- User profile and search -->
						<!-- ============================================================== -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="<?= base_url(IMG_DIR_USUARIOS . '/' . $imagen) ?>" alt="Usuario" width="45" class="profile-pic rounded-circle" />
								<span class="ms-1 font-weight-medium d-none d-sm-inline-block"><?= $nombre_completo_usuario ?> <i data-feather="chevron-down" class="feather-sm"></i></span>
							</a>
							<div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
								<div class="d-flex no-block align-items-center p-3 bg-primary text-white mb-2">
									<div class="">
										<img src="<?= base_url(IMG_DIR_USUARIOS . '/' . $imagen) ?>" alt="Usuario" class="rounded-circle" width="60">
									</div>
									<div class="ms-2">
										<h4 class="mb-0 text-white"><?= $nombre_completo_usuario ?></h4>
										<p class=" mb-0"><?= $email_usuario ?></p>
									</div>
								</div>
								<a class="dropdown-item" href="<?= route_to('perfil_' . $nombre_r) ?>">
									<i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> Mi perfil
								</a>
								<a class="dropdown-item" href="<?= route_to('cambiar_password') ?>">
									<i data-feather="lock" class="feather-sm text-info me-1 ms-1"></i> Cambiar contraseña
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= route_to('logout') ?>">
									<i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i> Cerrar sesión
								</a>
							</div>
						</li>
						<!-- ============================================================== -->
						<!-- User profile and search -->
						<!-- ============================================================== -->
					</ul>
				</div>
			</nav>
		</header>
		<!-- ============================================================== -->
		<!-- End Topbar header -->
		<!-- ============================================================== -->

		<!-- ============================================================== -->
		<!-- Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<aside class="left-sidebar" style="background: #A7250D;">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav" style="background: #A7250D;">
						<?= $menu ?>
					</ul>
				</nav>
				<!-- End Sidebar navigation -->
			</div>
			<!-- End Sidebar scroll-->
			<!-- Bottom points-->
			<div class="sidebar-footer" style="background: #A7250D;">
				<a href="<?= route_to('perfil_' . $nombre_r) ?>" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Mi perfil">
					<i data-feather="user" class="feather"></i>
				</a>
				<a href="<?= route_to('about_' . $nombre_r) ?>" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Información del gestor">
					<i data-feather="info" class="feather"></i>
				</a>
				<a href="<?= route_to('logout') ?>" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar sesión">
					<i data-feather="log-out" class="feather-sm"></i>
				</a>
			</div>
			<!-- End Bottom points-->
		</aside>
		<!-- ============================================================== -->
		<!-- End Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->

		<!-- ============================================================== -->
		<!-- Page wrapper  -->
		<!-- ============================================================== -->
		<div class="page-wrapper">
			<!-- ============================================================== -->
			<!-- Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->
			<div class="page-breadcrumb">
				<div class="row">
					<!-- *********************************************** -->
					<!-- ****************** BREADCRUMB ***************** -->
					<?= $breadcrumb ?>
					<!-- *********************************************** -->
					<!-- *********************************************** -->
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- End Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->

			<!-- ============================================================== -->
			<!-- Container fluid  -->
			<!-- ============================================================== -->

			<div class="container-fluid">
				<!-- *********************************************** -->
				<!-- ************* CONTENIDO PRINCIPAL ************* -->
				<?= $this->renderSection("contenido") ?>




				<!-- *********************************************** -->
				<!-- *********************************************** -->
			</div>
			<!-- ============================================================== -->
			<!-- End Container fluid  -->
			<!-- ============================================================== -->

			<!-- ============================================================== -->
			<!-- footer -->
			<!-- ============================================================== -->
			<footer class="footer text-center">
				&#0169; <script>
					document.write(new Date().getFullYear())
				</script> <?= NOMBRE_SISTEMA ?>. Todos los derechos reservados TIAMLab.
			</footer>
			<!-- ============================================================== -->
			<!-- End footer -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Page wrapper  -->
		<!-- ============================================================== -->
	</div>

	<!-- Modal para Notificación Individual -->
	<div class="modal fade" id="notificacionModal" tabindex="-1" aria-labelledby="notificacionModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="notificacionModalLabel">Notificación</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- Contenido dinámico del modal -->
					<div class="d-flex align-items-center mb-3">
						<span id="modalIcon" class="btn btn-info text-white btn-circle me-2">
							<i id="modalIconFeather" data-feather="info" class="feather-sm fill-white"></i>
						</span>
						<div>
							<h5 id="modalTitulo" class="mb-1">Título de la Notificación</h5>
							<p id="modalMensaje">Mensaje de la notificación</p>
							<small id="modalFecha" class="text-muted">No hay fecha</small>
						</div>
					</div>
					<!-- Campo oculto para almacenar el rol -->
					<input type="hidden" id="modalRol" value="" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="marcarComoLeido">Hecho</button>
				</div>
			</div>
		</div>
	</div>





	<!-- Modal para Ver Todas las Notificaciones -->
	<div class="modal fade" id="verTodasModal" tabindex="-1" aria-labelledby="verTodasModalLabel" aria-hidden="true" <?php echo empty($notificaciones) ? 'style="display:none;"' : ''; ?>>
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="verTodasModalLabel">Todas las Notificaciones</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?php if (!empty($notificaciones)) : ?>
						<?php foreach ($notificaciones as $notificacion) : ?>
							<div class="d-flex align-items-center border-bottom mb-2 p-2">
								<?php
								$btnClass = 'btn-info'; // Default
								$icon = 'info'; // Default icon

								switch ($notificacion['tipo_notificacion']) {
									case 'success':
										$btnClass = 'btn-success';
										$icon = 'check';
										break;
									case 'warning':
										$btnClass = 'btn-warning';
										$icon = 'alert-triangle';
										break;
									case 'danger':
										$btnClass = 'btn-danger';
										$icon = 'alert-octagon';
										break;
								}
								?>
								<span class="btn <?= $btnClass ?> text-white btn-circle me-2">
									<i data-feather="<?= $icon ?>" class="feather-sm fill-white"></i>
								</span>
								<div>
									<h6 class="message-title mb-0"><?= htmlspecialchars($notificacion['titulo_notificacion'], ENT_QUOTES, 'UTF-8') ?></h6>
									<p class="mb-0"><?= htmlspecialchars($notificacion['mensaje'], ENT_QUOTES, 'UTF-8') ?></p>
									<small class="text-muted"><?= htmlspecialchars($notificacion['fecha'] ?? 'No hay fecha', ENT_QUOTES, 'UTF-8') ?></small>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="text-center text-muted">No hay notificaciones</div>
					<?php endif; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->

	<!-- ============================================================== -->
	<!-- All Required JS -->
	<!-- ============================================================== -->
	<script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/jquery/dist/jquery.min.js') ?>"></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
	<!-- apps -->
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/app.min.js') ?>"></script>
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/app.init.js') ?>"></script>
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/app-style-switcher.js') ?>"></script>
	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') ?>"></script>
	<script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/jquery-sparkline/jquery.sparkline.min.js') ?>"></script>
	<!--Wave Effects -->
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/waves.js') ?>"></script>
	<!--Menu sidebar -->
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/sidebarmenu.js') ?>"></script>
	<!--Custom JavaScript -->
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/feather.min.js') ?>"></script>
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/custom.min.js') ?>"></script>
	<!-- Constants Js -->
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/constants.js'); ?>"></script>
	<!-- Notification Js (Toastr) -->
	<script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.js'); ?>"></script>
	<script src="<?= base_url(RECURSOS_PANEL_JS . '/notificaciones.js'); ?>"></script>
	<!-- ============================================================== -->
	<!-- End All Required JS -->
	<!-- ============================================================== -->


	<!-- ********************************************************** -->
	<!-- *************** JS ESPECÍFICOS DE LA VISTA *************** -->
	<?= $this->renderSection("js") ?>
	<!-- ********************************************************** -->
	<!-- ********************************************************** -->
	<?= mostrar_mensaje(); ?>
</body>

</html>