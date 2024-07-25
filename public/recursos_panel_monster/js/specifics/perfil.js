$.validator.addMethod( "emailRegex", function( value, element ) {
	return this.optional( element ) || /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test( value );
}, "No corresponde a una ruta de email" );


// FORM USUARIO_PERFIL VALIDATION
// =================================================================
$("#formulario-mi-perfil").validate({
    rules:{
        nombre: {
            required: true,
            rangelength: [3, 50]
        },
        ap_paterno: {
            required: true,
            rangelength: [3, 50]
        },
        ap_materno: {
            required: true,
            rangelength: [3, 50]
        },
        email: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        }
    },//end rules
    messages: {
        nombre: {
            required: 'Se requiere el nombre del usuario.',
            rangelength: 'El nombre debe tener entre 3 y 50 caracteres.'
        },
        ap_paterno: {
            required: 'Se requiere el apellido paterno del usuario.',
            rangelength: 'El apellido paterno debe tener entre 3 y 50 caracteres.'
        },
        ap_materno: {
            required: 'Se requiere el apellido materno del usuario.',
            rangelength: 'El apellido materno debe tener entre 3 y 50 caracteres.'
        },
        email: {
            required: 'Se requiere el correo electrónico del usuario.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
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

//FUNCIONES JS QUE SIRVEN PARA VALIDAR EL CHECKBOX Y RADIO BUTTON
$("#formulario-mi-perfil").submit(function(event){
    if($('.radio-item:checked').length <= 0) {
        event.preventDefault();
        mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
    }//end if no hay ningun radiobutton activo
});

$(document).on('click', '#masculino', function() {
	if(document.getElementById('imagen_perfil').value == '' && document.getElementById('img').getAttribute('data-image') == 'false'){
		let idImg = document.getElementById('img');
		idImg.src = BASE_URL(I_D_O+'/no-image-m.png');
		urlImg = BASE_URL(I_D_O+'/no-image-m.png');
	}//end if no hay imagen cargada
	document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '"+urlImg+"', 512, 512);");
});//end onclick sexo masculino

$(document).on('click', '#femenino', function() {
	if(document.getElementById('imagen_perfil').value == '' && document.getElementById('img').getAttribute('data-image') == 'false'){
		let idImg = document.getElementById('img');
		idImg.src = BASE_URL(I_D_O+'/no-image-f.png');
		urlImg = BASE_URL(I_D_O+'/no-image-f.png');
	}//end if no hay imagen cargada
	document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '"+urlImg+"', 512, 512);");
});//end onclick sexo femenino
