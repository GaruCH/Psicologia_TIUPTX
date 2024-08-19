let loader = new Loader('loader');

//INSERTAR PSICÓLOGO
//================================================================
document.getElementById('formulario-imagen-nueva').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

     // Verificar si se ha seleccionado una imagen
     const inputFile = document.getElementById('imagen_perfil');
     if (inputFile.files.length === 0) {
         mensaje_notificacion('No has seleccionado ninguna imagen.', 'warning', '¡No hay cambios!', 3000);
         return;  // Detener la ejecución si no hay imagen seleccionada
     }

    // Asegúrate de ejecutar tu lógica de validación antes de este punto
    loader.setLoaderTitle('Actualizando la imagen del usuario, por favor espere...');
    loader.setLoaderBody('Por favor espere en lo que se actualiza la imagen...');
    loader.openLoader();

    fetch('./perfil/actualizar-imagen', {
        method: 'POST',
        body: new FormData(document.getElementById('formulario-imagen-nueva'))
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Ocurrió un error');
        }
        return res.json();
    })
    .then(respuesta => {
        mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

        if (respuesta.error === 0) {
            // Mantener el loader activo mientras se muestra la notificación
            setTimeout(() => {
                loader.closeLoader();  // Cerrar el loader después del tiempo de la notificación
                location.reload();      // Recargar la página
            }, respuesta.timer_message);
        } else {
            loader.closeLoader();  // Cerrar el loader si hubo un error
        }
    })
    .catch(error => {
        loader.closeLoader();
        mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al actualizar!', 4000);
    });
});
