document.addEventListener('DOMContentLoaded', function() {
    var marcarComoLeidoBtn = document.getElementById('marcarComoLeido');
    var notificacionModal = document.getElementById('notificacionModal');

    marcarComoLeidoBtn.addEventListener('click', function () {
        var notificationId = notificacionModal.getAttribute('data-id');
        console.log(notificationId);
        fetch('./confirmar_notificacion', {
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
                // Hide the notification from the dropdown
                document.querySelector(`[data-id="${notificationId}"]`).closest('.message-item').remove();
                // Close the modal
                var modal = bootstrap.Modal.getInstance(notificacionModal);
                modal.hide();
                // Reload the page
                location.reload();
            } else {
                alert('Error al marcar la notificación como leída');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    notificacionModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var notificationId = button.getAttribute('data-id');
        notificacionModal.setAttribute('data-id', notificationId);
    });
});
