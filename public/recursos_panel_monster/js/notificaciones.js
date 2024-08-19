document.addEventListener('DOMContentLoaded', function () {
    var marcarComoLeidoBtn = document.getElementById('marcarComoLeido');
    var notificacionModal = document.getElementById('notificacionModal');

    // Evento cuando se muestra el modal
    notificacionModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // El botón que activó el modal

        // Obtener los datos del botón
        var notificationId = button.getAttribute('data-id');
        var titulo = button.getAttribute('data-titulo');
        var mensaje = button.getAttribute('data-mensaje');
        var rol = button.getAttribute('data-rol');
        var tipo = button.getAttribute('data-tipo');
        var fecha = button.getAttribute('data-fecha');

        // Configurar los datos en el modal
        if (notificacionModal) {
            notificacionModal.setAttribute('data-id', notificationId);
        }

        var modalTitulo = document.getElementById('modalTitulo');
        var modalMensaje = document.getElementById('modalMensaje');
        var modalFecha = document.getElementById('modalFecha');
        var modalIcon = document.getElementById('modalIcon');
        var modalIconFeather = document.getElementById('modalIconFeather');
        var modalRol = document.getElementById('modalRol');

        if (modalTitulo) modalTitulo.textContent = titulo;
        if (modalMensaje) modalMensaje.textContent = mensaje;
        if (modalFecha) modalFecha.textContent = fecha;
        if (modalRol) modalRol.value = rol; // Establecer el rol en el campo oculto

        if (modalIcon && modalIconFeather) {
            // Cambiar el icono y el color del botón según el tipo de notificación
            switch (tipo) {
                case 'success':
                    modalIcon.className = 'btn btn-success text-white btn-circle me-2';
                    modalIconFeather.setAttribute('data-feather', 'check');
                    break;
                case 'warning':
                    modalIcon.className = 'btn btn-warning text-white btn-circle me-2';
                    modalIconFeather.setAttribute('data-feather', 'alert-triangle');
                    break;
                case 'danger':
                    modalIcon.className = 'btn btn-danger text-white btn-circle me-2';
                    modalIconFeather.setAttribute('data-feather', 'alert-octagon');
                    break;
                default:
                    modalIcon.className = 'btn btn-info text-white btn-circle me-2';
                    modalIconFeather.setAttribute('data-feather', 'info');
                    break;
            }

            // Actualizar los íconos Feather
            feather.replace();
        }
    });

    // Evento para marcar la notificación como leída
    if (marcarComoLeidoBtn) {
        marcarComoLeidoBtn.addEventListener('click', function () {
            var notificationId = notificacionModal.getAttribute('data-id');
            var modalRol = document.getElementById('modalRol');
            
            var rol = modalRol.value;
            var urlBase;
            if (rol === 'Psicologo') {
                urlBase = window.location.origin + '/psicologo/';
            } else if (rol === 'Admin') {
                urlBase = window.location.origin + '/admin/';
            } else if (rol === 'Superadmin') {
                urlBase = window.location.origin + '/superadmin/';
            } else if (rol === 'Paciente') {
                urlBase = window.location.origin + '/paciente/';
            } else {
                // Fallback en caso de que el rol no sea reconocido
                console.error('Rol no reconocido');
                return;
            }

            var urlActual = urlBase + 'confirmar_notificacion';

            fetch(urlActual, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id: notificationId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar la notificación del dropdown
                        var notificationElement = document.querySelector(`[data-id="${notificationId}"]`);
                        if (notificationElement) {
                            notificationElement.closest('.message-item').remove();
                        }

                        // Cerrar el modal
                        var modal = bootstrap.Modal.getInstance(notificacionModal);
                        modal.hide();

                        // Recargar la página si es necesario
                        location.reload();
                    } else {
                        alert('Error al marcar la notificación como leída');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});
