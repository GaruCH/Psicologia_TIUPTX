// DATATABLE
// =================================================================
let basic_table = instantiateBasicDatatable();


// BOTONES OPCIONES
// =================================================================
$(document).on('click', '.estatus', function() {
	let elemento = $(this).attr('id');
	let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
	let array = ['./estatus_usuario', id, estatus, 'este usuario', 'podrá ingresar al sistema.'];
	let url = './administracion_usuarios';
    cambiar_estatus(array,url);
});//end onclick estatus

$(document).on('click', '.eliminar', function() {
    let url = './administracion_usuarios';
    eliminar("./eliminar_usuario", $(this).attr('id'), '¿Estás seguro de eliminar a este usuario?', 'Esta acción es permanente', url);
});//end onclick eliminar

$(document).on('click', '.change-password', function() {
	let clean_elements = {'password': '', 'confirm_password': '', 'id_usuario': ''};
	resetear_formulario('formulario-cambiar-password', clean_elements, false);

    document.getElementById('id_usuario').value = $(this).attr('id').split('_')[1];
    let modal_change_password = new bootstrap.Modal(document.getElementById('cambiar-password'));
    modal_change_password.show();
});//end onclick change-password

$(document).on('click', '.recover-user', function() {
    let titulo = '¿Deseas recuperar a este usuario?';
    let texto = 'Al recuperar este usuario volverá a estar disponible en la base de datos del sistema y podrá ser visualizado en el panel. ¿Estás seguro de restaurar a este usuario?';
    let texto_confirmar = 'Sí, restaurar el usuario';
    let texto_cancelar = 'Cancelar';
    let opciones_form = ['./restaurar_usuario', 'POST'];
	let data = new FormData();
	data.append('id', $(this).attr('id').split('_')[1]);
    mensaje_confirmacion_texto_propio(titulo, texto, texto_confirmar, texto_cancelar, opciones_form, data);
});//end onclick recover-user



$.validator.addMethod( "passRegex", function( value, element ) {
	return this.optional( element ) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test( value );
}, "Debe escoger una contraseña segura" );

// FORM CAMBIAR_PASSWORD VALIDATION
// =================================================================
$("#formulario-cambiar-password").validate({
    rules:{
        password:{
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_password: {
            required: true,
            equalTo: '#password',
            rangelength: [8, 16],
            passRegex: true
        }
    },//end rules
    messages: {
        password: {
            required: 'Se requiere la nueva contraseña para el usuario.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        },
        confirm_password: {
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



//==============================================================================
//==================================ON PAGE LOADED==============================
//==============================================================================
$(document).ready(function() {
    document.getElementById('cancel-form-change-password').onclick = function() {
        let clean_elements = {'password': '', 'confirm_password': '', 'id_usuario': ''};
        resetear_formulario('formulario-cambiar-password', clean_elements, false);
    };
});
