
//==============================================================================
//==============SECCIÓN PARA CAMBIAR CONTRASEÑA USUARIO=========================
//==============================================================================


$.validator.addMethod("passRegex", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test(value);
}, "Debe escoger una contraseña segura");


// FORM CAMBIAR_PASSWORD VALIDATION
// =================================================================
$("#formulario-cambiar-password-usuario-panel").validate({
    rules: {
        password_usuario_panel: {
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_password_usuario_panel: {
            required: true,
            equalTo: '#password_usuario_panel',
            rangelength: [8, 16],
            passRegex: true
        }
    },//end rules
    messages: {
        password_usuario_panel: {
            required: 'Se requiere la nueva contraseña para el usuario.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        },
        confirm_password_usuario_panel: {
            required: 'Se requiere confirmar la nueva contraseña.',
            equalTo: 'Las contraseñas no coinciden.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        }
    },//end messages
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },//end highlight
    unhighlight: function (input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },//end unhighlight
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }//end errorPlacement
});//end validation



$(document).on('click', '.cambiar-password-usuario-panel', function () {
    let clean_elements = { 'password_usuario_panel': '', 'confirm_password_usuario_panel': '', 'id_usuario_pass_panel': '' };
    resetear_formulario('formulario-cambiar-password-usuario-panel', clean_elements, false);

    // Obtener el ID del psicólogo desde el botón y asignarlo al campo oculto
    let usuarioId = $(this).attr('id').split('_')[1];
    //console.log('ID del psicólogo:', psicologoId); // Agrega este log para depuración
    document.getElementById('id_usuario_pass_panel').value = usuarioId;

    let modal_change_password = new bootstrap.Modal(document.getElementById('cambiar-password-usuario-panel'));
    modal_change_password.show();
});//end onclick change-password


document.getElementById('formulario-cambiar-password-usuario-panel').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    if ($('#formulario-cambiar-password-usuario-panel .is-invalid').length == 0) {
        loader.setLoaderTitle('Actualizando la contraseña del usuario, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se actualiza tu contraseña...');
        loader.openLoader();

        fetch('./cambiar-contraseña', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-cambiar-password-usuario-panel'))
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Ocurrió un error');
                }
                return res.json();
            })
            .then(respuesta => {
                loader.closeLoader();
                mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

                if (respuesta.error === 0) {
                    $('#formulario-cambiar-password-usuario-panel')[0].reset();
                    $('.invalid-feedback').text('');
                    feather.replace();
                    $('#formulario-cambiar-password-usuario-panel .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-cambiar-password-usuario-panel .form-check-input').removeClass('is-valid is-invalid');
                    $('#cambiar-password-usuario-panel').modal('hide');
                }
            })
            .catch(error => {
                loader.closeLoader();
                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al actualizar!', 4000);
            });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});



