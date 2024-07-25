$.validator.addMethod( "passRegex", function( value, element ) {
	return this.optional( element ) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test( value );
}, "Debe escoger una contraseña segura" );

$.validator.addMethod( "emailRegex", function( value, element ) {
    return this.optional( element ) || /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i.test( value );
}, "No corresponde a una ruta de email" );

$.validator.addMethod("numeric", function(value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
}, "Solo se permiten números");
// FORM USUARIO_NUEVO VALIDATION
// =================================================================
$("#formulario-paciente-nuevo").validate({
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
        subcategoria: {
            required: true
        },
        emailr: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        },
        edad: {
            required: true,
            min: 15,
            max: 99,
            rangelength: [1, 2],
            numeric: true,
        },
        passwordr:{
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_passwordr: {
            required: true,
            equalTo: '#passwordr',
            rangelength: [8, 16],
            passRegex: true
        }
    },//end rules
    messages: {
        nombre: {
            required: 'Se requiere el nombre del paciente.',
            rangelength: 'El nombre debe tener entre 3 y 50 caracteres.'
        },
        ap_paterno: {
            required: 'Se requiere el apellido paterno del paciente.',
            rangelength: 'El apellido paterno debe tener entre 3 y 50 caracteres.'
        },
        ap_materno: {
            required: 'Se requiere el apellido materno del paciente.',
            rangelength: 'El apellido materno debe tener entre 3 y 50 caracteres.'
        },
        subcategoria: {
            required: 'Se requiere seleccionar una ocupación para el paciente.'
        },
        emailr: {
            required: 'Se requiere el correo electrónico del paciente.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
        },
        edad: {
            required: 'Se requiere la edad del paciente.',
            min: "La edad mínima es 15",
            max: "La edad máxima es 99",
            rangelength: 'La edad no debe exceder los 2 caracteres.',
            numeric: "Solo se permiten números"
        },
        passwordr: {
            required: 'Se requiere la contraseña para el paciente.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        },
        confirm_passwordr: {
            required: 'Se requiere confirmar la contraseña del paciente.',
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

//FUNCIONES JS QUE SIRVEN PARA VALIDAR EL CHECKBOX Y RADIO BUTTON
$("#formulario-paciente-nuevo").submit(function(event){
    if($('.radio-item:checked').length <= 0) {
        event.preventDefault();
		mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
    }//end if no hay ningun radiobutton activo
});

$(document).on('click', '#masculino', function() {
	document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);");
	if(document.getElementById('imagen_perfil').value == ''){
		let urlImg = BASE_URL(I_D_O+'/no-image-m.png');
	    let idImg = document.getElementById('img');
	    idImg.src = urlImg;
	}//end if no hay imagen cargada
});//end onclick sexo masculino

$(document).on('click', '#femenino', function() {
	document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-f.png', 512, 512);");
	if(document.getElementById('imagen_perfil').value == ''){
		let urlImg = BASE_URL(I_D_O+'/no-image-f.png');
	    let idImg = document.getElementById('img');
	    idImg.src = urlImg;
	}//end if no hay imagen cargada
});//end onclick sexo femenino

// Limitar la entrada a 2 dígitos
$('#edad').on('input', function() {
    if (this.value.length > 2) {
        this.value = this.value.slice(0, 2);
    }
});

// Prevenir ingreso de más de dos dígitos
$('#edad').on('keypress', function(e) {
    if (this.value.length >= 2) {
        e.preventDefault();
    }
});



